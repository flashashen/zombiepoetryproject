package flash.zombie.nlp;

import flash.zombie.nlp.realize.Realizer;
import flash.zombie.nlp.realize.ZombieTokens;
import org.junit.Test;

/**
 *
 */
public class RealizerTest {

    @Test
    public void testLineLengthSmoother() throws Exception {

        //Decomposition decomposition = new Decomposition("test sentence")
        ZombieTokens zombieTokens = new ZombieTokens();
        zombieTokens.addText("test");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("a");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("sentence");
        zombieTokens.addSpaceOrPunctuation(".");
        zombieTokens.addSpaceOrPunctuation(".");
        zombieTokens.terminateLine();
        zombieTokens.terminateSentence();
        zombieTokens.addText("this");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("another");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("much");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("much");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("much");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("much");
        zombieTokens.addSpaceOrPunctuation(" ");
        zombieTokens.addText("longer");
        zombieTokens.terminateLine();
        zombieTokens.addText("sentence");
        zombieTokens.addSpaceOrPunctuation(".");
        zombieTokens.terminateLine();
        zombieTokens.terminateSentence();

        zombieTokens.preprocessLineBreaks();

        while(zombieTokens.smoothLineLengths()>0){
            System.out.println(zombieTokens);
        }



    }
}