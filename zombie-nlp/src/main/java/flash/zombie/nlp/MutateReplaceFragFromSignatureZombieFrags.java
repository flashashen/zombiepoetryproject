package flash.zombie.nlp;

import edu.stanford.nlp.ling.StringLabel;
import edu.stanford.nlp.trees.Tree;

import java.util.concurrent.ThreadLocalRandom;

/**
 *
 */
public class MutateReplaceFragFromSignatureZombieFrags extends MutationStatisticalRegexOperation {



    public String mutate(Tree matchingNode){
       // String fragment = getRandomFragment();
        Tree matchingChild = null;
        Integer fragmentChildIndex = null;
        for (int i=0; i<matchingNode.numChildren(); i++){
            matchingChild = matchingNode.getChild(i);
            if ("FRAG".equals(matchingChild.value())){
                fragmentChildIndex = i;
                break;
            }
        }

        if (fragmentChildIndex != null){
            //matchingNode.setChild(fragmentChildIndex, fragment);
            String matchString = Decomposition.getRoughRealization(matchingNode);
            matchingChild.setLabel(new StringLabel("SIGNATURE_FRAG"));
            matchingChild.setValue(getRandomFragment());
            matchingChild.setChildren(new Tree[]{});
            return "- replace ["
                    +  matchString
                    + "] with ["
                    +  matchingChild.value()
                    + "]";
        }

        return "- failed to find mactched FRAG. Check code";
    }



    public MutateReplaceFragFromSignatureZombieFrags(int percentageChomped, Decomposition progenitorDecomposition) {
        super("__ < FRAG", percentageChomped, progenitorDecomposition);
//
//        FRAGMENTS = new Decomposition(frags).getParse().toArray(new Tree[0]);
    }

    @Override
    public String toString() {
        return "MutateReplaceFragFromSignatureZombieFrags{" +
                "percentageChomped=" + getPercentageChomped() +
                ", patternTargetString='" + getPatternTargetString() + '\'' +
                '}';
    }

    public String getRandomFragment(){
        return FRAGMENTS[
                ThreadLocalRandom.current().nextInt(0, FRAGMENTS.length)
                ];
    }

    static final String[] FRAGMENTS = {
            "is this innocence, surviving at the cost of mind?",
                    "honestly, I don’t know where to go from here.",
                    "this, friend, is where we are.",
                    "what else?",
                    "alluvial soil, detrital dirt, turning world.",
                    "Movement.",
                    "You are a stranger, sight to see.",
                    "My God, what have you done? What will you become?",
                    "I was not myself then; I am not me now. ",
                    " (Now, hold on a sec, before you get the wrong idea. Let me segue, let me keep you since I’ve got you).",
                    "Mute the voice. ",
                    "Do you remember? ",
                    "Inside, you feel the chill. ",
                    "Do not look to the sky. ",
                    "It’s all for you. ",
                    "Deep blues. ",
                    "Oh, You’re close. ",
                    "Please, Please stop.",
                    "Take me back to my work. ",
                    "Against your will, you’ll feel it then.",
                    "Are you nervous? ",
                    "Entirely plausible.",
                    "Might’ve been any one of us? ",
                    "Don’t worry. ",
                    "It’s a zombie life we lead. "};

}
