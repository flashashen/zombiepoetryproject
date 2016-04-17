package flash.zombie.nlp.model;

import com.fasterxml.jackson.annotation.JsonIdentityReference;
import com.fasterxml.jackson.annotation.JsonIgnore;
import edu.stanford.nlp.trees.PennTreeReader;
import edu.stanford.nlp.trees.Tree;

import java.io.IOException;
import java.io.StringReader;
import java.util.ArrayList;
import java.util.List;

/**
 *
 */
public class Sentence {

    public boolean attack = false;
    public String text;
    @JsonIgnore
    public Tree parseTree;
    public List<String> mutations = new ArrayList<>();



    public boolean isAttack() {
        return attack;
    }

    public void setAttack(boolean attack) {
        this.attack = attack;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public Tree getParseTree() {
        return parseTree;
    }

    public void setParseTree(Tree parseTree) {
        this.parseTree = parseTree;
    }

    public String getParseString() {
        return parseTree.pennString();
    }

    public void setParseString(String parseString) throws IOException {
        PennTreeReader reader = new PennTreeReader(new StringReader(parseString));
        this.parseTree = reader.readTree();
        if (reader.readTree() != null)
            throw new RuntimeException("Extra tree was read from sentence pennstring. Expecting just one.");
        //this.parseTree = parseTree;
    }


    public List<String> getMutations() {
        return mutations;
    }

    public void setMutations(List<String> mutations) {
        this.mutations = mutations;
    }

}
