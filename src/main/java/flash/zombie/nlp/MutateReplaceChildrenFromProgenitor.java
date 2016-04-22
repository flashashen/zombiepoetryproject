package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

/**
 *
 */
public class MutateReplaceChildrenFromProgenitor extends MutationStatisticalRegexOperation {


    public String mutate(Tree matchingNode){
        return replaceChildren(matchingNode, findProgenitorMatch(matchingNode));
    }

    public static String replaceChildren(Tree target, Tree source){
        String pennString = Decomposition.getRoughRealization(target);
        target.setChildren(source.getChildrenAsList());
        return "- replace [" + pennString + "] with [" + Decomposition.getRoughRealization(source) + "]";
    }

    public MutateReplaceChildrenFromProgenitor(String matchPattern, int percentageChomped, Decomposition progenitorDecomposition) {
        super(matchPattern, percentageChomped, progenitorDecomposition);
    }

    @Override
    public String toString() {
        return "MutateReplaceChildrenFromProgenitor{" +
                "percentageChomped=" + getPercentageChomped() +
                ", patternTargetString='" + getPatternTargetString() + '\'' +
                '}';
    }
}
