package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

/**
 *
 */
public class MutateReplaceNNFromProgenitor extends MutationStatisticalRegexOperation {


    public String mutate(Tree matchingNode){
        Tree progentitorMatched = findProgenitorMatch(matchingNode);
        String pennString = Decomposition.getRoughRealization(matchingNode);
        matchingNode.setChildren(progentitorMatched.getChildrenAsList());
        return "NN replace [" + pennString + "] with [" + Decomposition.getRoughRealization(matchingNode) + "]";

    }


    public MutateReplaceNNFromProgenitor(int percentageChomped, Decomposition progenitorDecomposition) {
        super( "NP !> S < DT < NN", percentageChomped, progenitorDecomposition);
    }

    @Override
    public String toString() {
        return "MutateReplaceNNFromProgenitor{" +
                "percentageChomped=" + getPercentageChomped() +
                ", patternTargetString='" + getPatternTargetString() + '\'' +
                '}';
    }
}
