package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

/**
 *
 */
public class MutateReplaceChildrenFromProgenitor extends MutationStatisticalRegexOperation {


    public String mutate(Tree matchingNode){
        Tree progentitorMatched = findProgenitorMatch(matchingNode);
        String pennString = Decomposition.getRoughRealization(matchingNode);
        matchingNode.setChildren(progentitorMatched.getChildrenAsList());
        return "- replace [" + pennString + "] with [" + Decomposition.getRoughRealization(matchingNode) + "]";

    }


    public MutateReplaceChildrenFromProgenitor(int percentageChomped, Decomposition progenitorDecomposition) {
      //  super( "NP !> S < DT < NN", percentageChomped, progenitorDecomposition);
        super( "NP (< SBAR | < NN | < NNS )", percentageChomped, progenitorDecomposition);
    }

    @Override
    public String toString() {
        return "MutateReplaceChildrenFromProgenitor{" +
                "percentageChomped=" + getPercentageChomped() +
                ", patternTargetString='" + getPatternTargetString() + '\'' +
                '}';
    }
}
