package flash.zombie.nlp.realize;

import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.tregex.TregexMatcher;
import edu.stanford.nlp.trees.tregex.TregexPattern;
import edu.stanford.nlp.util.StringUtils;
import flash.zombie.nlp.model.Incident;
import flash.zombie.nlp.model.Sentence;

import java.io.StringWriter;
import java.util.ArrayList;
import java.util.List;
import java.util.Map;

/**
 * Created by panelson on 3/19/16.
 */
public class Realizer {

  //  Decomposition decomposition;
    int characterCounter;
    int lineCounter;



    ZombieTokens zombieTokens;



 //   StringWriter stringWriterZombie;

//    public Realizer(Decomposition decomposition) {
//        this.decomposition = decomposition;
//    }

    public String realize(Incident incident, int linesPerStanza) {


        characterCounter = 0;
        lineCounter = 0;
        zombieTokens = new ZombieTokens();

        StringWriter aggregateWriter = new StringWriter();;

        for (Sentence sentence : incident.getZombie()) {
//            stringWriterZombie = new StringWriter();
            writeSentence(sentence, null);
//            sentence.setText(stringWriterZombie.toString());

            // temporarily keep writing to the aggregate
//            String sentenceString = stringWriterZombie.toString();
//            aggregateWriter.write(sentenceString);

            // new realizer data. indicate sentence break.
            zombieTokens.terminateSentence();
       }

        while(zombieTokens.smoothLineLengths() > 0);
        zombieTokens.applyStanza(linesPerStanza);
        zombieTokens.setZombieText(incident);

        return zombieTokens.toString();
    }


    //  private static final TregexPattern endOfPhrasePattern = TregexPattern.compile("__ (>>- VP |  >>- NP) $,, __");
    private static final TregexPattern endOfPhrasePattern = TregexPattern.compile("NN | NNS | NNP | NNPS | VB | VBD | VBG | VBN | VBP | VB | VBZ");


    private void scoreForLineBreaks(Sentence sentence) {

        // Mark the last words of phrases to help with line breaks
        //     List<Tree> zombieParse = decomposition.getParse();
        Tree node;
        TregexMatcher m = endOfPhrasePattern.matcher(sentence.getParseTree());
        while (m.findNextMatchingNode()) {
            node = m.getMatch();
            if (node.isPreTerminal()) {
                // m.getMatch().getChild(0).setLabel(Decomposition.MARKER_LAST_WORD_OF_PHRASE);
                if (node.value().startsWith("V") && node.getChild(0).value().length() <= 2)
                    node.getChild(0).setScore(0);

                else {
                    node.getChild(0).setScore(100);
                }
            }
        }
    }


    private void writeSentence(Sentence sentence, Map<Tree, Object> entites) {

        scoreForLineBreaks(sentence);

        // Operate on preTerminals
        ArrayList<Tree> preTerminals = new ArrayList<>();
        for (Tree prenode : sentence.getParseTree().preOrderNodeList()) {
            if (prenode.isPreTerminal()) {
                preTerminals.add(prenode);
            }
        }

        Tree[] nodes = preTerminals.toArray(new Tree[0]);
        Tree node;
        Tree lastNode = null;
        Tree nextNode = null;
        Tree childNode = null;


        for (int i = 0; i < nodes.length; i++) {

            node = nodes[i];

            lastNode = (i > 0) ? nodes[i - 1] : null;
            nextNode = (i < nodes.length - 1) ? nodes[i + 1] : null;
            childNode = node.firstChild();

            if (isComma(nextNode)) nextNode = null;

            System.out.println("Realizer: node (child) value *** " + ((childNode == null) ? "null" : childNode.value()) + " ***");


            if (isComma(node)) {
                System.out.println("Realizer: comma: " + childNode.value());

                // Ignore most commas but replace a few with em-dash
                if (characterCounter > 5 && characterCounter < 25 && Math.random() * 100 >= 100 - 20) {
                    //stringWriterZombie.append(" --");
                    zombieTokens.addSpaceOrPunctuation(" --");
                    System.out.println("Realizer: append ' --'");
                } else {
                    // ignore
                    System.out.println("Realizer: ignoring comma");
                    continue;
                }
            }

            // Open quote has a space before and none after
            else if (isOpenQuote(childNode)) {
                System.out.println("Realizer: openquote: " + childNode.value());
                //stringWriterZombie.append(' ');
                zombieTokens.addSpaceOrPunctuation(" ");
                System.out.println("Realizer: append space before open quote");
                //stringWriterZombie.append(childNode.value());
                zombieTokens.addSpaceOrPunctuation(childNode.value());
            }

            else if (isPunctuation(childNode)) {
                if (isDash(childNode)){
                    //stringWriterZombie.append(' ');
                    zombieTokens.addSpaceOrPunctuation(" ");
                }
                System.out.println("Realizer: punctution: " + childNode.value());
                //stringWriterZombie.append(childNode.value());
                zombieTokens.addSpaceOrPunctuation(childNode.value());
                //stringWriterZombie.append(' ');
            }

            else {

                System.out.println("Realizer: non punctutaion: " + childNode.value());

                if ("-RSB-".compareToIgnoreCase(childNode.value()) == 0)
                    childNode.setValue("]");
                else if ("-LSB-".compareToIgnoreCase(childNode.value()) == 0)
                    childNode.setValue("[");
                else if ("-LRB-".compareToIgnoreCase(childNode.value()) == 0)
                    childNode.setValue("(");
                else if ("-RRB-".compareToIgnoreCase(childNode.value()) == 0)
                    childNode.setValue(")");

                // Assure capitalization is correct
                if (lastNode == null) {
                    childNode.setValue(StringUtils.capitalize(childNode.value()));
                    System.out.println("Realizer: Cap - lastnode null:  " + childNode.value());
                } else if (isTerminal(lastNode)) {
                    childNode.setValue(StringUtils.capitalize(childNode.value()));
                    System.out.printf("Realizer: Cap - after terminal: last=%s this=%s\n", lastNode.firstChild().value(), childNode.value());
                } else if ("i".equals(childNode.value())) {
                    childNode.setValue(StringUtils.capitalize(childNode.value()));
                    System.out.println("Realizer: Cap - 'i' always: \n" + childNode.value());
                }
//                else { //   TODO fix entity recognition if (entites.containsKey(childNode)) {
//                    childNode.setValue(StringUtils.capitalize(childNode.value()));
//                    System.out.println("Cap - entity:  " + childNode.value());
//                }
//                else
                System.out.println("Realizer: Cap - leave as is:  " + childNode.value());


                // Turn off decapitalizaiton for now. If a word is cap'd only becaese it begins
                // a sentence and it is moved then it will remain cap'd incorrectly for now
//                    else
//                        node.setValue(node.value().toLowerCase());

                // If notcoming off a line break, open quote or current node starts w apostrophe
                if (characterCounter > 0
                        && !nodeIsSpace(lastNode)
                        && !isOpenQuote(lastNode)
                        && !isRightPartPossesiveOrContraction(childNode)) {
                    //stringWriterZombie.append(' ');
                    zombieTokens.addSpaceOrPunctuation(" ");
                    System.out.println("Realizer: append space");
                }


                System.out.println("Realizer: append value: " + childNode.value());
                //stringWriterZombie.append(childNode.value());
                zombieTokens.addNode(childNode, ZombieToken.ZombieTokenType.WORD);
                characterCounter += childNode.value().length();

            }

            if (newLine_v2(lastNode, node, nextNode, characterCounter)) {
                //stringWriterZombie.append('\n');
                zombieTokens.terminateLine();

//                // Add extra line break for quick stanzas
//                lineCounter++;
//                if (lineCounter%4==0){
//                    //stringWriterZombie.append('\n');
//                    zombieTokens.terminateStanza();
//                }

                //String zombieLine = stringWriterZombie.toString();
                //transformation.zombieTextLines.add(zombieLine);
                characterCounter = 0;
            }

        }
    }

//    public static final AmericanEnglish AE = new AmericanEnglish();

//    private void languageToolCorrection(String sentence) throws IOException {
//
//        JLanguageTool langTool = new MultiThreadedJLanguageTool(AE);
//
////langTool.activateDefaultPatternRules();  -- only needed for LT 2.8 or earlier
//        List<RuleMatch> matches = langTool.check(sentence);
//
//        for (RuleMatch match : matches) {
//            System.out.println("Potential error at line " +
//                    match.getLine() + ", column " +
//                    match.getColumn() + ": " + match.getMessage());
//            System.out.println("Suggested correction: " +
//                    match.getSuggestedReplacements());
//        }
//    }

    private boolean isComma(Tree node){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        return (",".equals(node.value()));
    }

    private boolean isRightPartPossesiveOrContraction(Tree node){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        return (node.value().length() > 1 && node.value().contains("'"));
    }

    private boolean isPunctuation(Tree node){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        return ("`").equals(node) || StringUtils.isPunct(node.value());
    }

    private boolean leafValueIs(Tree node, String value){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        return value.equals(node.value());
    }

    private boolean leafValueIsOneOf(Tree node, String ... values){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        for (String value : values){
            if (value.equals(node.value())) return true;
        }

        return false;
    }

    private boolean isOpenQuote(Tree node){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        String value = node.value();
        return (("``").equals(node.value()) || ("`").equals(node.value()) || "\u201c".equals(value));
    }

    private boolean isDash(Tree node){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        String value = node.value();
        return (("-").equals(node.value()) || ("--").equals(node.value()));
    }



    private boolean isTerminal(Tree node){

        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        return ".".equals(node.value())
                || "-".equals(node.value())
                || "!".equals(node.value())
                || "?".equals(node.value());
    }

    private boolean eligibleForLineBreak(Tree node){
        if (node == null) return false;
        if (node.isPreTerminal())
            node = node.getChild(0);
        return (node.score() > 0) || isTerminal(node) || leafValueIsOneOf(node, ";", ":") || isOpenQuote(node);
    }

    private double getScore(Tree node){
        if (node == null) return 0;
        if (node.isPreTerminal())
            node = node.getChild(0);
        return node.score();
    }

    private boolean nodeIsSpace(Tree node){
        return (node != null && " ".equals(node.value()));
    }
//    private boolean lowQualityVerb(Tree node){
//        return (node != null && node.value().startsWith("V") > );
//    }



//    Line Breaks:
//
//            1. Limit break to NN, NNS, NNP, NNPS or VB, VBD, VBG, VBN, VBP or VBZ
//    2. Line lengths between 8 and 50 characters with 75% of breaks between 30-40 characters. This should provide enough of a range for the algorythm to find the line break, yes? I like the larger outer range, because it might mimic contemporary free verse.



    private static final int LINE_LENGTH_LOWER_BOUND = 8;
    private static final int LINE_LENGTH_UPPER_BOUND = 50;
    private static final int LINE_LENGTH_MIDDLE_START = 25;




    private boolean newLine_v2(Tree lastNode, Tree thisNode, Tree nextNode, int characterCounter){

        System.out.printf("new line check: tag is '%s' -> '%s'.  char count:%d   elibible:%s\n",
                thisNode.label(), thisNode.getChild(0).value(), characterCounter, String.valueOf(eligibleForLineBreak(thisNode)));

        // Can't begin a new line with punctuation unless it's an open quote
        if (isPunctuation(nextNode) && !isOpenQuote(nextNode)) {
            System.out.println("new line check: punctuation - return false.\n");
            return false;
        }

        // Must meet at least lower bound
        if (characterCounter < LINE_LENGTH_LOWER_BOUND) {
            System.out.println("new line check: characterCounter < LINE_LENGTH_LOWER_BOUND - return false.\n");
            return false;
        }

        // Don't exceed hard upper limit
//        if (characterCounter > LINE_LENGTH_UPPER_BOUND
//                || (nextNode != null && nextNode.getChild(0).value().length()+characterCounter > LINE_LENGTH_UPPER_BOUND)) {
//            return true;
//        }


        // If lower bound is reached and tag is eligible, then break at percentage equal to the character count (8-30)

        // If 'middle' point is reached and tag is eligible, then break
        if (characterCounter > LINE_LENGTH_MIDDLE_START && eligibleForLineBreak(thisNode)) {
            System.out.println("new line check: Middle bound reached. insert line break.\n");
            return true;
        }

//        // Break on terminal punctuation
//        else if (characterCounter > LINE_LENGTH_MIDDLE_START && isTerminal(thisNode)) {
//            System.out.println("new line check: Terminal punctuation. insert line break.\n");
//            return true;
//        }


        else if (characterCounter > LINE_LENGTH_LOWER_BOUND && characterCounter >= LINE_LENGTH_MIDDLE_START && eligibleForLineBreak(thisNode)) {
            double randomValue = Math.random()*100;
            System.out.printf("new line check: Lower bound reached. break if random is lower than char count: random=%f. char count=%d\n", randomValue, characterCounter);
            if (randomValue < characterCounter) {
                return true;
            }
        }

        System.out.println("new line check: no line break.\n");
        return false;
    }

//
//    private boolean newLine_v1(Tree lastNode, Tree thisNode, Tree nextNode, int characterCounter){
//
//        if (isPunctuation(nextNode))
//            return false;
//
//        if (characterCounter > LINE_LENGTH_UPPER_BOUND) {
//            return true;
//        }
//
//        // If the line is will be made too long by a very long word, then break now
//        if (characterCounter > LINE_LENGTH_SUFFICIENT && nextNode != null && nextNode.value().length() > 10) {
//            return true;
//        }
//
//        // Break on terminal punctuation
//        if (characterCounter > LINE_LENGTH_SUFFICIENT && isTerminal(thisNode)) {
//            return true;
//        }
//
//        // If the line is likely to end in a low value word (a, the, etc), then break now
//        if (characterCounter > LINE_LENGTH_SUFFICIENT && nextNode != null && nextNode.value().length() < 4) {
//            return true;
//        }
//
//        // If this node is the end of a phrase then break as long as lower bound is reached
//        if (characterCounter > LINE_LENGTH_LOWER_BOUND && eligibleForLineBreak(thisNode)) {
//            return true;
//        }
//
//        return false;
//    }

}
