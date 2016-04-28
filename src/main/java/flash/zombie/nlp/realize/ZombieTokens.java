package flash.zombie.nlp.realize;

import edu.stanford.nlp.trees.Tree;
import flash.zombie.nlp.model.Sentence;

import java.io.StringWriter;
import java.util.ArrayList;
import java.util.List;

/**
 *
 */
public class ZombieTokens {


    static final int lineLenVarianceThreshold = 10;



    public void addText(String text) {
        ZombieToken token = new ZombieToken(ZombieToken.ZombieTokenType.WORD);
        token.text = text;
        add(token);
    }

    public void addSpaceOrPunctuation(String text) {
        ZombieToken token = new ZombieToken(ZombieToken.ZombieTokenType.NON_WORD);
        token.text = text;
        add(token);
    }

    public void terminateSentence() {
        add(new ZombieToken(ZombieToken.ZombieTokenType.ST));
    }

    public void terminateLine() {
        ZombieToken token = new ZombieToken(ZombieToken.ZombieTokenType.LB);
        token.text = "\n";
        add(token);
    }

    public void terminateStanza() {
        ZombieToken token = new ZombieToken(ZombieToken.ZombieTokenType.STZ);
        token.text = "\n";
        add(token);
    }

    public void add(ZombieToken token) {
        token.prior = last;
        token.next = null;
        last.next = token;
        last = token;
    }

    private ZombieToken remove(ZombieToken token) {
        if (token.prior != null)
            token.prior.next = token.next;
        if (token.next != null)
            token.next.prior = token.prior;
        return token;
    }

    private ZombieToken insertAfter(ZombieToken insertToken, ZombieToken afterThis) {
        insertToken.next = afterThis.next;
        insertToken.prior = afterThis;
        afterThis.next = insertToken;
        return insertToken;
    }

    public void addNode(Tree node, ZombieToken.ZombieTokenType type) {

        if (node == null) return;

        if (node.isPreTerminal())
            node = node.getChild(0);

        ZombieToken token = new ZombieToken(type);
        token.text = node.value();
        token.lineBreakScore = node.score();
        add(token);
    }


    public void preprocessLineBreaks() {

        ZombieToken current = root;
        int sentenceIndex = 0;
        int characterCount = 0;
        int totalCharacterCount = 0;
        lineBreaks = new ArrayList<>();

        while (current != null) {

            // Text, punctuation, line breaks are all just written to the buffer
            if (current.text != null) {
                characterCount += current.text.length();

                if (ZombieToken.ZombieTokenType.LB.equals(current.type)) {
                    lineBreaks.add(current);
                    current.lineBreakScore = new Double(characterCount);
                    totalCharacterCount += characterCount;
                    characterCount = 0;
                }
            }

            current = current.next;
        }

        averageLineLength = totalCharacterCount / lineBreaks.size();
     }



    public void setSentenceText(List<Sentence> sentences) {

        ZombieToken current = root;
        int sentenceIndex = 0;
        StringWriter stringWriterZombie = new StringWriter();

        while (current != null) {

            // Text, punctuation, line breaks are all just written to the buffer
            if (current.text != null) {
                stringWriterZombie.write(current.text);
            }

            // terminate sentence on terminator
            if (ZombieToken.ZombieTokenType.ST.equals(current.type)) {
                sentences.get(sentenceIndex).setText(stringWriterZombie.toString());
                stringWriterZombie = new StringWriter();
                sentenceIndex++;
            }

            current = current.next;
        }

        if (sentenceIndex != sentences.size()) {
            throw new RuntimeException("Zombie token realizer didn't finish on ST of last sentence as expected");
        }
    }


    @Override
    public String toString() {
        return realize();
    }

    public String realize() {

        ZombieToken current = root;
        int sentenceIndex = 0;
        StringWriter stringWriterZombie = new StringWriter();

        while (current != null) {

            // Text, punctuation, line breaks are all just written to the buffer
            if (current.text != null) {
                stringWriterZombie.write(current.text);
            }
            else {
                stringWriterZombie.write("("+current.type.toString()+")");
            }

            current = current.next;
        }

        return  stringWriterZombie.toString();
    }



    public int smoothLineLengths() {

        int smothingOperations = 0;

        if (averageLineLength == null || lineBreaks == null)
            preprocessLineBreaks();

        ZombieToken currentLineBreak, nextLineBreak = null;

        for (int i = 0; i < lineBreaks.size() - 1; i++) {

            currentLineBreak = lineBreaks.get(i);
            nextLineBreak = lineBreaks.get(i + 1);
            int lineVariance = nextLineBreak.lineBreakScore.intValue()-currentLineBreak.lineBreakScore.intValue();

            // Current line is below average. Take.
            if (Math.abs(lineVariance) > lineLenVarianceThreshold) {
                int charactersShifted = lineBreakShift(currentLineBreak, lineVariance/2);
                if (charactersShifted != 0) {
                    currentLineBreak.lineBreakScore += charactersShifted;
                    nextLineBreak.lineBreakScore -= charactersShifted;
                    smothingOperations++;
                }
            }
        }

        // null line breaks since..
        //lineBreaks = null;
        return smothingOperations;

    }





    public class ZombieTokensTraverser {

        private boolean backwards = false;
        private ZombieToken current;


        public ZombieToken forward(){
            return current = (backwards) ? current.prior : current.next;
        }

        public ZombieToken backward(){
            return current = (backwards) ? current.next : current.prior;
        }

        public ZombieToken peekForward(){
            return (backwards) ? current.prior : current.next;
        }

        public ZombieToken peekBackward(){
            return (backwards) ? current.next : current.prior;
        }

        public ZombieToken current(){
            return current;
        }

        public boolean goesBackwards(){
            return backwards;
        }

        public void current(ZombieToken current){
            this.current = current;
        }

        /**
         * When traversing away from a given node, whether backwards or forwards, insert this
         * node at the spot just beyond (in the direction of traversal) the given node.
         *
         * @param beyondThis - node beyond which to insert this node.
         * @return - this node.
         */
        public ZombieToken insertCurrentBeyond(ZombieToken beyondThis){
            if (backwards)
                current.insertSelfBefore(beyondThis);
            else
                current.insertSelfAfter(beyondThis);
            return current;
        }


        public ZombieTokensTraverser(boolean backwards, ZombieToken startToken) {
            this.backwards = backwards;

            if (startToken != null)
                current = startToken;
            else {
                if (backwards)
                    current = last;
                else
                    current = root;
            }
        }
    }

    public int lineBreakShift(ZombieToken lineBreakToken, int targetShiftInCharacters){

        if (targetShiftInCharacters == 0) return 0;

        // Let the ZombieTokensTraverser handle the direction of the traversal and
        // make sure the target shift is positive so it's easier to deal with
        ZombieTokensTraverser traverser = new ZombieTokensTraverser((targetShiftInCharacters<0), lineBreakToken);
        targetShiftInCharacters = Math.abs(targetShiftInCharacters);

        //ZombieToken currentNode = lineBreakToken;
        ZombieToken targetNode = null, lastTargetNode = null;
        int targetNodeCharCount = 0, lastTargetNodeCharCount = 0;
        int characterCount = 0;

        // If need to add length to this line, shift LB to the right
        if (targetShiftInCharacters > 0){
            while (characterCount <= targetShiftInCharacters && traverser.current() != null){

                traverser.forward();

                if (traverser.current() != null && traverser.current().text != null) {

                    characterCount += traverser.current().text.length();

                    // Now set target nodes if current node meets criteria - just and WORD for now. add scoring next
                    if (ZombieToken.ZombieTokenType.WORD.equals(traverser.current().type)){
                        lastTargetNode = targetNode;
                        lastTargetNodeCharCount = targetNodeCharCount;
                        targetNode = traverser.current();
                        targetNodeCharCount = characterCount;
                    }
                }
            }
        }

        // At this point targetNode and lastTargetNode should be the nodes on either
        // side of the target variance. Pick one or none for the shift.

        int variance = Math.abs(targetShiftInCharacters-targetNodeCharCount);
        int lastVariance = Math.abs(targetShiftInCharacters-lastTargetNodeCharCount);

        if (lastTargetNodeCharCount > 0 && lastVariance < targetShiftInCharacters && lastVariance <= variance) {
            targetNode = lastTargetNode;
            targetNodeCharCount = lastTargetNodeCharCount;
        }
        else if (targetNodeCharCount > 0 && variance < targetShiftInCharacters) {
            // leave targetNode as it is.
        }
        else
            targetNode = null;

        // If there is a target node still set, then shift this line break after it.
        // If traversing forwards, include the next token if it's not fit to start a sentence.
        // A backwards traversal should always end on a word which is ok for sentence start.
        if (targetNode != null) {
            if (!traverser.goesBackwards() && targetNode.next != null && ZombieToken.ZombieTokenType.NON_WORD.equals(targetNode.next.type)) {
                targetNode = targetNode.next;
                targetNodeCharCount += targetNode.text.length();
            }
            ZombieToken space = new ZombieToken(ZombieToken.ZombieTokenType.NON_WORD);
            space.text = " ";
            traverser.current(lineBreakToken.replace(space));
            traverser.insertCurrentBeyond(targetNode);
            return (traverser.goesBackwards()) ? -targetNodeCharCount : targetNodeCharCount;
        }

        return 0;
    }


    ZombieToken root = new ZombieToken(ZombieToken.ZombieTokenType.ROOT);
    ZombieToken last = root;
    Integer averageLineLength = null;
    ArrayList<ZombieToken> lineBreaks = new ArrayList<>();




}
