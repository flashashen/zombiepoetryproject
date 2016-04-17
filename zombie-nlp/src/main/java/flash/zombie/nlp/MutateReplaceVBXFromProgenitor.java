package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

/**
 *
 */
public class MutateReplaceVBXFromProgenitor extends MutationStatisticalRegexOperation {


    public String mutate(Tree matchingNode){
        Tree progentitorMatched = findProgenitorMatch(matchingNode);
        String temp = matchingNode.value();
        matchingNode.setValue(progentitorMatched.value());
        return "VXX replace [" + temp + "] with [" + progentitorMatched.value() + "]";

    }


    public MutateReplaceVBXFromProgenitor(int percentageChomped, Decomposition progenitorDecomposition) {
        super( "VBG", percentageChomped, progenitorDecomposition);
    }

    @Override
    public String toString() {
        return "MutateReplaceVBXFromProgenitor{" +
                "percentageChomped=" + getPercentageChomped() +
                ", patternTargetString='" + getPatternTargetString() + '\'' +
                '}';
    }
}
