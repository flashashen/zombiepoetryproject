package flash.zombie.nlp;

import edu.stanford.nlp.ling.CoreAnnotations;
import edu.stanford.nlp.ling.StringLabel;
import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.pipeline.StanfordCoreNLP;
import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.TreeCoreAnnotations;
import edu.stanford.nlp.trees.tregex.TregexMatcher;
import edu.stanford.nlp.trees.tregex.TregexPattern;
import edu.stanford.nlp.util.CoreMap;
import edu.stanford.nlp.util.StringUtils;
import sun.jvm.hotspot.code.DeoptimizationBlob;

import java.io.StringWriter;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;

/**
 *
 *  This class represents the Zombie progenitor. It contains a decomposition of the original
 *  Zombie text and collection of mutations. The public method is simply attack(String text)
 *  which applies the mutations and generates the zombified text.
 *
 */
public class Progenitor {


    public void attack(String text, Incident transformation){

        Decomposition decomposition = new Decomposition(text);
        mutate(decomposition);
        recompose(decomposition, transformation);
    }




    private void mutate(Decomposition decomposition){

        // Apply all transformations
        for (Mutation mutation : mutations){
            mutation.mutate(decomposition); // mutate tree? or need to replace old tree with new?
        }

    }


    private void recompose(Decomposition decomposition, Incident transformation) {

        transformation.zombieText = "";

        List<Object> entites = decomposition.getEntities();
        //System.out.print(entites);


        // Mark the last words of phrases to help with line breaks
        List<Tree> zombieParse = decomposition.getParse();
        for (Tree tree : zombieParse) {
            TregexMatcher m = endOfPhrasePattern.matcher(tree);
            while (m.findNextMatchingNode())
                if (m.getMatch().isPreTerminal()) {
                   // m.getMatch().getChild(0).setLabel(Decomposition.MARKER_LAST_WORD_OF_PHRASE);
                    m.getMatch().getChild(0).setScore(100);
                }
        }


        int characterCounter = 0;
        Tree lastNode = null;
        Tree nextNode = null;
        StringWriter stringWriterZombie = new StringWriter();
        Tree node;
        boolean newLine = false;

        for (Tree sentence : zombieParse) {

            // Traverse the tree in order
            Tree[] nodes = sentence.getLeaves().toArray(new Tree[0]);

            for (int i=0; i<nodes.length; i++) {

                node = nodes[i];
                if (!node.isLeaf()) continue;

                lastNode = (i>0) ? nodes[i-1] : null;
                nextNode = (i<nodes.length-1) ? nodes[i+1] : null;
                if (isComma(nextNode)) nextNode = null;

                if (isComma(node)) {
                    // Ignore most commas but replace a few with em-dash
                    if (characterCounter > 5 && characterCounter < 25 && Math.random()*100 >= 100-20)
                        stringWriterZombie.append(" --");
                    else
                        // ignore
                        continue;
                }

//                else if (isTerminal(node)){
//                    //newLine = true;
//                    stringWriterZombie.append(node.value());
////                    if (characterCounter > 35) {
////                        newLine = true;
//                }

                else if (isPunctuation(node)){
                    // semi-colon, colon .. what else?
                    stringWriterZombie.append(node.value());
                }

                else {

                    // Assure capitalization is correct
                    if (entites.contains(node.value()) || lastNode == null || isTerminal(lastNode))
                        node.setValue(StringUtils.capitalize(node.value()));
                    else
                        node.setValue(node.value().toLowerCase());

                    stringWriterZombie.append(' ');

                    stringWriterZombie.append(node.value());
                    characterCounter += node.value().length();

                }

                if (newLine(lastNode, node, nextNode, characterCounter)){
                    // stringWriterZombie.append("\n");
                    String zombieLine = stringWriterZombie.toString();
                    transformation.zombieText += zombieLine;
                    transformation.zombieTextLines.add(zombieLine);
                    stringWriterZombie = new StringWriter();
                    characterCounter = 0;
                }
            }
        }

        // Add any text leftover
        if (characterCounter > 0) {
            String zombieLine = stringWriterZombie.toString();
            transformation.zombieText += zombieLine;
            transformation.zombieTextLines.add(zombieLine);
        }

    }




    private boolean isComma(Tree node){
        return (node != null && ",".equals(node.value()));
    }

    private boolean isPunctuation(Tree node){
        return (node != null && StringUtils.isPunct(node.value()));
    }

    private boolean isTerminal(Tree node){

        if (node == null) return false;

        return ".".equals(node.value())
                || "!".equals(node.value())
                || "?".equals(node.value());
    }

    private boolean isEndOfPhrase(Tree node){
        return (node != null && node.score() > 0);
    }


    private static final int LINE_LENGTH_UPPER_BOUND = 35;
    private static final int LINE_LENGTH_LOWER_BOUND = 25;
    private static final int LINE_LENGTH_SUFFICIENT = 30;

    private boolean newLine(Tree lastNode, Tree thisNode, Tree nextNode, int characterCounter){

        if (isPunctuation(nextNode))
            return false;

        if (characterCounter > LINE_LENGTH_UPPER_BOUND) {
            return true;
        }

        // If the line is will be made too long by a very long word, then break now
        if (characterCounter > LINE_LENGTH_SUFFICIENT && nextNode != null && nextNode.value().length() > 10) {
            return true;
        }

        // Break on terminal punctuation
        if (characterCounter > LINE_LENGTH_SUFFICIENT && isTerminal(thisNode)) {
            return true;
        }

        // If the line is likely to end in a low value word (a, the, etc), then break now
        if (characterCounter > LINE_LENGTH_SUFFICIENT && nextNode != null && nextNode.value().length() < 4) {
            return true;
        }

        // If this node is the end of a phrase then break as long as lower bound is reached
        if (characterCounter > LINE_LENGTH_LOWER_BOUND && isEndOfPhrase(thisNode)) {
            return true;
        }

        return false;
    }


    public Progenitor() {
        init();
    }

    private void init() {

        // Pre-analyze the progenitor poem for use by mutation objects
        progenitorDecomposition = new Decomposition(ZOMBIE);

        mutations = new ArrayList<>();
        mutations.add(new MutateSwapPPWithSibling(25, progenitorDecomposition));
        mutations.add(new MutateReplaceNNFromProgenitor(100, progenitorDecomposition));

    }

    public Decomposition getDecomposition(){
        return progenitorDecomposition;
    }


    private static final TregexPattern endOfPhrasePattern = TregexPattern.compile("__ (>>- VP |  >>- NP) $,, __");

    private Decomposition progenitorDecomposition;
    private List<Mutation> mutations;
    private final String ZOMBIE = "Another town, another attack: Shots, then a show of conflagration. Blood rushes from our limbs, grooving the old channels, pooling hearts and minds. [Our Zombie Life] We bring to our bright screens our heat and our tears, proclaiming, as one, the suddenness of our pain, pleading to let some good be born of this. Buy my book, this one quickly shares, which alone might console and explain. The rest of us decide, without conviction, not to chirp a word. Is this innocence, surviving at the cost of mind? The country, still, is better, where blackbirds shawl the treetops, mimic the huffing wind. At night, the scent of skunk slices clean through the walls to where dreams spool and roll in bellies that growl and burst";



}
