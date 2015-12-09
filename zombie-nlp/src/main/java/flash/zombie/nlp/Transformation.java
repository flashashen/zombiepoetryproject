package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

import java.util.ArrayList;

/**
 * Created by flash on 12/8/15.
 */
public class Transformation {

    public String victimText;
    public ArrayList<Tree> victimParseTrees;

    public String zombieText;



    public String getVictimText() {
        return victimText;
    }

    public void setVictimText(String victimText) {
        this.victimText = victimText;
    }

    public ArrayList<Tree> getVictimParseTrees() {
        return victimParseTrees;
    }

    public void setVictimParseTrees(ArrayList<Tree> victimParseTrees) {
        this.victimParseTrees = victimParseTrees;
    }

    public String getZombieText() {
        return zombieText;
    }

    public void setZombieText(String zombieText) {
        this.zombieText = zombieText;
    }
}
