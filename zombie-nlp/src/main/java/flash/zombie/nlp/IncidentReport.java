package flash.zombie.nlp;

import java.io.Serializable;
import java.util.List;

/**
 *
 */
public class IncidentReport implements Serializable {

    String zombie;
    public List<String> zombieMutations;

    public IncidentReport() {
    }

    public IncidentReport(String zombie) {
        this.zombie = zombie;
    }

    public String getZombie() {
        return zombie;
    }

    public void setZombie(String zombie) {
        this.zombie = zombie;
    }

    public List<String> getZombieMutations() {
        return zombieMutations;
    }

    public void setZombieMutations(List<String> zombieMutations) {
        this.zombieMutations = zombieMutations;
    }
}
