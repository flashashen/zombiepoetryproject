package flash.zombie.nlp.model;

import edu.stanford.nlp.trees.Tree;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by flash on 12/8/15.
 */
public class Incident {

    public String victimText;
    //    public List<Tree> victimParseTrees;
//    public List<Tree> zombieParseTrees;
    public String zombieText;
//    public List<String> zombieMutations;
//    public List<String> zombieTextLines;

    List<Sentence> victim;
    List<Sentence> zombie;


//    public Incident() {
//        victim = new ArrayList<Tree>();
//        zombie = new ArrayList<Tree>();
//        zombieTextLines = new ArrayList<String>();
//    }


    public String getVictimText() {
        return victimText;
    }

    public void setVictimText(String victimText) {
        this.victimText = victimText;
    }

    public String getZombieText() {
        return zombieText;
    }

    public void setZombieText(String zombieText) {
        this.zombieText = zombieText;
    }

    public List<Sentence> getVictim() {
        return victim;
    }

    public void setVictim(List<Sentence> victim) {
        this.victim = victim;
    }

    public List<Sentence> getZombie() {
        return zombie;
    }

    public void setZombie(List<Sentence> zombie) {
        this.zombie = zombie;
    }
}
