package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

/**
 *
 */
public class MutateReplaceNNFromProgenitor extends MutationStatisticalRegexOperation {


    public void mutate(Tree matchingNode){
        Tree progentitorMatched = findProgenitorMatch(matchingNode);
        String pennString = matchingNode.pennString();
        matchingNode.setChildren(progentitorMatched.getChildrenAsList());
        mutationDescriptions.add("replaced " + pennString + " with " + matchingNode.pennString());

    }


    public MutateReplaceNNFromProgenitor(int percentageChomped, Decomposition progenitorDecomposition) {
        super( "NP !> S < DT < NN", percentageChomped, progenitorDecomposition);
    }
}
