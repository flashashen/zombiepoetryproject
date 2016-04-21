package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

/**
 *
 */
public class MutateReplaceVBDFromProgenitor extends MutationStatisticalRegexOperation {


    public String mutate(Tree matchingNode){
        Tree progentitorMatched = findProgenitorMatch(matchingNode);
        String temp = matchingNode.value();
        matchingNode.setValue(progentitorMatched.value());
        return "VBD replace [" + temp + "] with [" + progentitorMatched.value() + "]";

    }


    public MutateReplaceVBDFromProgenitor(int percentageChomped, Decomposition progenitorDecomposition) {
        super( "VBD", percentageChomped, progenitorDecomposition);
    }

    @Override
    public String toString() {
        return "MutateReplaceVBDFromProgenitor{" +
                "percentageChomped=" + getPercentageChomped() +
                ", patternTargetString='" + getPatternTargetString() + '\'' +
                '}';
    }
}
