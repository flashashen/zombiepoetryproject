package flash.zombie.nlp;

import edu.stanford.nlp.ling.CoreAnnotations;
import edu.stanford.nlp.ling.CoreLabel;
import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.pipeline.StanfordCoreNLP;
import edu.stanford.nlp.semgraph.SemanticGraph;
import edu.stanford.nlp.semgraph.SemanticGraphCoreAnnotations;
import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.TreeCoreAnnotations;
import edu.stanford.nlp.trees.tregex.TregexPattern;
import edu.stanford.nlp.trees.tregex.tsurgeon.Tsurgeon;
import edu.stanford.nlp.trees.tregex.tsurgeon.TsurgeonPattern;
import edu.stanford.nlp.util.CoreMap;
import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;
import org.springframework.ui.Model;

import java.io.StringWriter;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;


@Controller
@EnableAutoConfiguration
class ZombieTransform {



    @ModelAttribute("transformation")
    public Transformation getTransformation(){
        return new Transformation();
    }

    @RequestMapping("/master")
    @ResponseBody
    String master() {
        return
                zombieMasterText;
    }

//
//    @RequestMapping("/master/select")
//    @ResponseBody
//    String master(String tregex) {
//        return
//                zombieMasterText;
//    }

    @ModelAttribute
    public Transformation transformation(@RequestParam(required=false) String text) {
        Transformation transformation = new Transformation();
        transformation.victimText = text;
        return transformation;
    }


    @RequestMapping(value="/victim"/*,  method= RequestMethod.POST*/)
//    @ResponseBody
    public String victim(
            Transformation transformation, Model model) {

        if (transformation.victimText == null) return "victim";

//        Tree t = Tree.valueOf("(ROOT (S (NP (NP (NNP Bank)) (PP (IN of) (NP (NNP America)))) (VP (VBD called)) (. .)))");
//        TregexPattern pat = TregexPattern.compile("NP <1 (NP << Bank) <2 PP=remove");
//        TsurgeonPattern surgery = Tsurgeon.parseOperation("excise remove remove");
//        Tsurgeon.processPattern(pat, surgery, t).pennPrint();


        // create an empty Annotation just with the given text
        Annotation document = new Annotation(transformation.victimText);

        // run all Annotators on this text
        pipeline.annotate(document);

        StringWriter stringWriter = new StringWriter();
        List<CoreMap> sentences = document.get(CoreAnnotations.SentencesAnnotation.class);
        ArrayList<Tree> trees = new ArrayList<Tree>(sentences.size());

        for(CoreMap sentence: sentences) {
            // traversing the words in the current sentence
            // a CoreLabel is a CoreMap with additional token-specific methods
//            for (CoreLabel token: sentence.get(CoreAnnotations.TokensAnnotation.class)) {
//                // this is the text of the token
//                String word = token.get(CoreAnnotations.TextAnnotation.class);
//                // this is the POS tag of the token
//                String pos = token.get(CoreAnnotations.PartOfSpeechAnnotation.class);
//                // this is the NER label of the token
//                String ne = token.get(CoreAnnotations.NamedEntityTagAnnotation.class);
//            }

            // this is the parse tree of the current sentence
            Tree tree = sentence.get(TreeCoreAnnotations.TreeAnnotation.class);
            trees.add(tree);

            stringWriter.append(tree.pennString());


            // this is the Stanford dependency graph of the current sentence
            //SemanticGraph dependencies = sentence.get(SemanticGraphCoreAnnotations.CollapsedCCProcessedDependenciesAnnotation.class);
        }


        //pipeline.process(victim);
//        Transformation transformation = new Transformation();
//        transformation.victimText = text;
        transformation.victimParseTrees = trees;
        transformation.zombieText = stringWriter.toString();
        model.addAttribute("transformation", transformation);

        // Return name of view to render
        return "victim";
    }







    private void init() {
        Properties properties = new Properties();
        properties.setProperty("annotators", corenlpAnnotators);
        pipeline = new StanfordCoreNLP(properties);
    }



    public String getCorenlpAnnotators() {
        return corenlpAnnotators;
    }

    public void setCorenlpAnnotators(String corenlpAnnotators) {
        this.corenlpAnnotators = corenlpAnnotators;
    }

    private StanfordCoreNLP pipeline;
    String zombieMasterText = "nother town, another attack: Shots, then a show of conflagration. Blood rushes from our limbs, grooving the old channels, pooling hearts and minds. [Our Zombie Life]";
    String corenlpAnnotators = "tokenize, ssplit, pos, lemma, ner, parse, dcoref";

    public ZombieTransform() {
        init();
    }

}