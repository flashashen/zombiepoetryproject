package flash.zombie.nlp;

import edu.stanford.nlp.trees.Tree;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by flash on 12/8/15.
 */
public class Incident {

    public String victimText;
    public List<Tree> victimParseTrees;
    public List<Tree> zombieParseTrees;
    public String zombieText;


    public Incident() {
        victimParseTrees = new ArrayList<Tree>();
        zombieParseTrees = new ArrayList<Tree>();
    }

    public String getVictimText() {
        return victimText;
    }

    public void setVictimText(String victimText) {
        this.victimText = victimText;
    }

    public List<Tree> getVictimParseTrees() {
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
