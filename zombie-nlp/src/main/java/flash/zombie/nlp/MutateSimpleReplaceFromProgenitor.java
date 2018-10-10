package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

/**
 *
 */
public class MutateSimpleReplaceFromProgenitor extends MutationStatisticalRegexOperation {


    public String mutate(Tree matchingNode){
        Tree progentitorMatched = findProgenitorMatch(matchingNode);
        if (progentitorMatched.isPreTerminal())
            progentitorMatched = progentitorMatched.firstChild();
        if (matchingNode.isPreTerminal())
            matchingNode = matchingNode.firstChild();
        String priorValue = matchingNode.value();
        matchingNode.setValue(progentitorMatched.value());
        return "- replace ["
                + priorValue
                + "] with ["
                + matchingNode.value()
                + "]";

    }

    public MutateSimpleReplaceFromProgenitor(String pattern, int percentageChomped, Decomposition progenitorDecomposition) {
        super(pattern, percentageChomped, progenitorDecomposition);
    }

    public MutateSimpleReplaceFromProgenitor(String targetPattern, String sourcePattern, int percentageChomped, Decomposition progenitorDecomposition) {
        super(targetPattern, sourcePattern, percentageChomped, progenitorDecomposition);
    }

    @Override
    public String toString() {
        return "MutateSimpleReplaceFromProgenitor{" +
                "percentageChomped=" + getPercentageChomped() +
                ", patternTargetString='" + getPatternTargetString() + '\'' +
                '}';
    }
}
