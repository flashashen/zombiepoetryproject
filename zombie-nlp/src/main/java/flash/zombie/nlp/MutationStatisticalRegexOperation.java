package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.tregex.TregexMatcher;
import edu.stanford.nlp.trees.tregex.TregexPattern;
import flash.zombie.nlp.model.Sentence;

import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ThreadLocalRandom;

/**
 *
 */
public abstract class MutationStatisticalRegexOperation implements Mutation {

    public void mutate(Sentence sentence){

        Tree victimRoot = sentence.getParseTree();
            TregexMatcher m = getPatternTarget().matcher(victimRoot);
            while (m.findNextMatchingNode()) {
                if (chompThisMatch(m.getMatch())) {
                    sentence.getMutations().add(mutate(m.getMatch()));
                }
            }
    }

    /**
     * Mutate the tree in place
     * @param matchingNode - next node matching the tregex pattern in the victim text
     * @return - Description of mutation applied
     */
    public abstract String mutate(Tree matchingNode);


    private int percentageChomped;
    private String patternTargetString;
    private TregexPattern patternTarget;
    private Decomposition progenitorDecomposition;
    protected List<String> mutationDescriptions;


    public MutationStatisticalRegexOperation(String patternTargetString, int percentageChomped, Decomposition progenitorDecomposition) {

        this.percentageChomped = percentageChomped;
        this.patternTargetString = patternTargetString;

        // Filter the tree list from the sentences of the zombie text to just a list
        // of source nodes for this transformation
//        for (Tree tree: zombieSourceTrees) {
//            TregexMatcher matcher = getPatternTarget().matcher(tree);
//            while (matcher.find())
//                tempTreeList.add(matcher.getMatch());
//        }

        this.progenitorDecomposition = progenitorDecomposition;

        // Put all matches from the progenitor text into an array
        ArrayList<Tree> tempTreeList = new ArrayList<Tree>();
        for (Tree tree : this.progenitorDecomposition.getParse()) {
            TregexMatcher m = getPatternTarget().matcher(tree);

            while (m.find())
                tempTreeList.add(m.getMatch());
        }
        progenitorMatchingNodes = tempTreeList.toArray(new Tree[0]);


    }

    public Tree findProgenitorMatch(Tree tree){
        return progenitorMatchingNodes[
                ThreadLocalRandom.current().nextInt(0, progenitorMatchingNodes.length)
                ];
    }

    public int getPercentageChomped() {
        return percentageChomped;
    }
    public void setPercentageChomped(int percentageChomped) {
        this.percentageChomped = percentageChomped;
    }

    public String getPatternTargetString() {
        return patternTargetString;
    }
    public void setPatternTargetString(String patternTargetString) {
        this.patternTargetString = patternTargetString;
    }

    public TregexPattern getPatternTarget() {
        if (patternTarget == null){
            patternTarget = TregexPattern.compile(patternTargetString);
        }
        return patternTarget;
    }


    @Override
    public String toString() {
        return "MutationStatisticalRegexOperation{" +
                "percentageChomped=" + percentageChomped +
                ", patternTargetString='" + patternTargetString + '\'' +
                '}';
    }

    private Tree[] progenitorMatchingNodes;
    boolean chompThisMatch(Tree tree){
        double value =  Math.random()*100;
        return (value >= 100-percentageChomped);
    }


}
