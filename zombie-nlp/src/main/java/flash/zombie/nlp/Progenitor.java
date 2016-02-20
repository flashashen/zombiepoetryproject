package flash.zombie.nlp;

import edu.stanford.nlp.ling.CoreAnnotations;
import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.pipeline.StanfordCoreNLP;
import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.TreeCoreAnnotations;
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


    public String attack(String text){

        Decomposition decomposition = new Decomposition(text);
        mutate(decomposition);
        return recompose(decomposition);
    }




    private void mutate(Decomposition decomposition){

        // Apply all transformations
        for (Mutation mutation : mutations){
            mutation.mutate(decomposition); // mutate tree? or need to replace old tree with new?
        }

    }


    private String recompose(Decomposition decomposition) {

        String zombieText = "";

        for (Tree sentence : decomposition.getParse()) {

            // Traverse the tree in order
            int characterCounter = 0;
            List<Tree> nodes = sentence.preOrderNodeList();
            StringWriter stringWriterZombie = new StringWriter();
            for (Tree node : nodes) {
                if (node.isLeaf() && !isComma(node)) {

                    if (!isPunctuation(node))
                        stringWriterZombie.append(' ');
                    stringWriterZombie.append(node.value());
                    characterCounter += node.nodeString().length();

                    // Temporary insert of line breaks. Better to add in tree structure as form of punctuation
//                    if (characterCounter > 30 && !isPunctuation(node)) {
//                        stringWriterZombie.append("\n");
//                        characterCounter = 0;
//                    }
                }
            }
           zombieText += stringWriterZombie.toString();
        }

        return zombieText;
    }




    private boolean isComma(Tree node){
        return ",".equals(node.nodeString());
    }

    private boolean isPunctuation(Tree node){
        return StringUtils.isPunct(node.nodeString());
    }


    public Progenitor() {
        init();
    }

    private void init() {

        // Pre-analyze the progenitor poem for use by mutation objects
        progenitorDecomposition = new Decomposition(ZOMBIE);

        mutations = new ArrayList<>();
        mutations.add(new MutationStatisticalRegexOperation(
                "NP !> S < DT < NN",
                "prune vdt",
                100,
                progenitorDecomposition
        ));
    }

    public Decomposition getDecomposition(){
        return progenitorDecomposition;
    }



    private Decomposition progenitorDecomposition;
    private List<Mutation> mutations;
    private final String ZOMBIE = "Another town, another attack: Shots, then a show of conflagration. Blood rushes from our limbs, grooving the old channels, pooling hearts and minds. [Our Zombie Life] We bring to our bright screens our heat and our tears, proclaiming, as one, the suddenness of our pain, pleading to let some good be born of this. Buy my book, this one quickly shares, which alone might console and explain. The rest of us decide, without conviction, not to chirp a word. Is this innocence, surviving at the cost of mind? The country, still, is better, where blackbirds shawl the treetops, mimic the huffing wind. At night, the scent of skunk slices clean through the walls to where dreams spool and roll in bellies that growl and burst";



}
