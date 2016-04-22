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
        mutate(sentence, false);
    }

    public void mutate(Sentence sentence, boolean force) {
        Tree victimRoot = sentence.getParseTree();
        TregexMatcher m = getPatternTarget().matcher(victimRoot);
        while (m.findNextMatchingNode()) {
            if (force || chompThisMatch(m.getMatch())) {
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


    public MutationStatisticalRegexOperation(String patternTargetString, int percentageChomped, Decomposition progenitorDecomposition) {
        init(patternTargetString, percentageChomped, progenitorDecomposition);
    }


    public synchronized void init(String patternTargetString, int percentageChomped, Decomposition progenitorDecomposition) {

        this.percentageChomped = percentageChomped;
        this.patternTargetString = patternTargetString;

        // Filter the tree list from the sentences of the zombie text to just a list
        // of source nodes for this transformation
//        for (Tree tree: zombieSourceTrees) {f
//            TregexMatcher matcher = getPatternTarget().matcher(tree);
//            while (matcher.find())
//                tempTreeList.add(matcher.getMatch());
//        }

        progenitorMatchingNodes = initializeProgenitorMatchingNodes(progenitorDecomposition);


    }

    public Tree[] initializeProgenitorMatchingNodes(Decomposition decomposition){
        // Put all matches from the progenitor text into an array
        ArrayList<Tree> tempTreeList = new ArrayList<Tree>();
        for (Tree tree : decomposition.getParse()) {
            TregexMatcher m = getPatternTarget().matcher(tree);

            while (m.find())
                tempTreeList.add(m.getMatch());
        }
        return tempTreeList.toArray(new Tree[0]);
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
