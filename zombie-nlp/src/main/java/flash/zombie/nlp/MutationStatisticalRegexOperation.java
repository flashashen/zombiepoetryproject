package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.Trees;
import edu.stanford.nlp.trees.tregex.TregexMatcher;
import edu.stanford.nlp.trees.tregex.TregexPattern;
import edu.stanford.nlp.trees.tregex.tsurgeon.Tsurgeon;
import edu.stanford.nlp.trees.tregex.tsurgeon.TsurgeonMatcher;

import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ThreadLocalRandom;

/**
 *
 */
public class MutationStatisticalRegexOperation implements Mutation {

    public void mutate(Decomposition decomposition){

        List<Tree> victimTrees = decomposition.getParse();
        for (Tree victim : victimTrees) {
            TregexMatcher m = getPatternTarget().matcher(victim);
            while (m.find()) {

                if (chompThisMatch(m.getMatch())) {
                    Tree progentitorMatched = findProgenitorMatch(m.getMatch());
                    m.getMatch().setChildren(progentitorMatched.getChildrenAsList());
                    //m.getMatch().pennPrint();
                    //progentitorMatched.pennPrint();

                }
            }
        }
    }

    private int percentageChomped;
    private String patternTargetString;
    private TregexPattern patternTarget;
    private Decomposition progenitorDecomposition;
    private String operationString;


    public MutationStatisticalRegexOperation(String patternTargetString, String operationString, int percentageChomped, Decomposition progenitorDecomposition) {

        this.percentageChomped = percentageChomped;
        this.patternTargetString = patternTargetString;
        this.operationString = operationString;

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

    public String getOperationString() {
        return operationString;
    }
    public void setOperationString(String operationString) {
        this.operationString = operationString;
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



    private Tree[] progenitorMatchingNodes;
    boolean chompThisMatch(Tree tree){
        return  (Math.random()*100 >= 100-percentageChomped);
    }


}