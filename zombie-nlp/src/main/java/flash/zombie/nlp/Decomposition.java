package flash.zombie.nlp;

import edu.stanford.nlp.ling.CoreAnnotations;
import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.pipeline.StanfordCoreNLP;
import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.TreeCoreAnnotations;
import edu.stanford.nlp.util.CoreMap;

import java.util.ArrayList;
import java.util.List;
import java.util.Properties;

/**
 * Contains an analysis of a text
 */
public class Decomposition {


    //private List<Tree> sentencesPartsOfSpeech;
    private final Annotation document;


    public Decomposition(String text) {
        Properties properties = new Properties();
        properties.setProperty("annotators", "tokenize, ssplit, pos, lemma, ner, parse, dcoref");
        StanfordCoreNLP pipeline = new StanfordCoreNLP(properties);
        document = new Annotation(text);
        pipeline.annotate(document);
    }


    public List<Tree> getParse() {
        List<CoreMap> sentences = document.get(CoreAnnotations.SentencesAnnotation.class);
        List<Tree> parseTrees = new ArrayList(sentences.size());
        for (CoreMap sentence : sentences) {
            Tree tree = sentence.get(TreeCoreAnnotations.TreeAnnotation.class);
            parseTrees.add(tree);
        }
        return parseTrees;
    }
}


//
//    private List<Tree> getListOfTreesFromText(String text){
//
//        Annotation document = new Annotation(text);
//        pipeline.annotate(document);
//        List<CoreMap> sentences = document.get(CoreAnnotations.SentencesAnnotation.class);
//        List<Tree> parseTrees = new ArrayList(sentences.size());
//        for(CoreMap sentence: sentences) {
//            // traversing the words in the current sentence
//            // a CoreLabel is a CoreMap with additional token-specific methods
////            for (CoreLabel token: sentence.get(CoreAnnotations.TokensAnnotation.class)) {
////                // this is the text of the token
////                String word = token.get(CoreAnnotations.TextAnnotation.class);
////                // this is the POS tag of the token
////                String pos = token.get(CoreAnnotations.PartOfSpeechAnnotation.class);
////                // this is the NER label of the token
////                String ne = token.get(CoreAnnotations.NamedEntityTagAnnotation.class);
////            }
//            // this is the parse tree of the current sentence
//            Tree tree = sentence.get(TreeCoreAnnotations.TreeAnnotation.class);
//            parseTrees.add(tree);
//        }
//        return parseTrees;
////    }
//



