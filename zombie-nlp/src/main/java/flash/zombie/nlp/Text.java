package flash.zombie.nlp;

import edu.stanford.nlp.ling.CoreAnnotations;
import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.TreeCoreAnnotations;
import edu.stanford.nlp.util.CoreMap;

import java.util.ArrayList;
import java.util.List;

/**
 *
 */
public class Text {

    public List<Tree> decomposition;
    public String composition;

    public Text() {
        this.decomposition = new ArrayList<>();
    }



}
