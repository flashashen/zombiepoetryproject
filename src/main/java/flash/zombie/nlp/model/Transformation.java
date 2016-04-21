package flash.zombie.nlp.model;

import java.util.List;

/**
 *
 */
public class Transformation {

    public String victimText;
    public String zombieText;
    List<Sentence> victim;
    List<Sentence> zombie;


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
