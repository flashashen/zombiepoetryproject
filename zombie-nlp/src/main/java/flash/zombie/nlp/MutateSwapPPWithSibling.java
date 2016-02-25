package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

import java.util.List;

/**
 *
 */
public class MutateSwapPPWithSibling extends MutationStatisticalRegexOperation {


    // Match the parent of prepositional phrases that have an NP or VBZ sibling
    private static final String MATCH_PATTERN = "__ < (PP [ $ NP | $ VBZ ])";


    public void mutate(Tree matchingNode){

        Tree node = null;
        Integer ppNodeIndex = null, swapNodeIndex = null;

        // Identify PP and noun/verb indexes in child array
        Tree[] children = matchingNode.children();
        for (int i=0; i<children.length; i++){
            node = children[i];
            if ("PP".equals(node.value())) {
                ppNodeIndex = i;
            }
            else if ("NP".equals(node.value()) || "VBZ".equals(node.value())) {
                swapNodeIndex = i;
            }
        }

        // Swap the PP and noun/verb node
        if (ppNodeIndex != null && swapNodeIndex != null){
            node = children[swapNodeIndex];
            children[swapNodeIndex] = children[ppNodeIndex];
            children[ppNodeIndex] = node;
            mutationDescriptions.add("swapped " + children[swapNodeIndex].pennString()
                    + " with " + children[ppNodeIndex].pennString());
        }
    }


    public MutateSwapPPWithSibling(int percentageChomped, Decomposition progenitorDecomposition) {
        super(MATCH_PATTERN, percentageChomped, progenitorDecomposition);
    }
}
