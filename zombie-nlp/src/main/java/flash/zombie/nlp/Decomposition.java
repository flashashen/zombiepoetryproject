package flash.zombie.nlp;

import edu.stanford.nlp.ling.CoreAnnotations;
import edu.stanford.nlp.ling.CoreLabel;
import edu.stanford.nlp.ling.Label;
import edu.stanford.nlp.ling.StringLabel;
import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.pipeline.StanfordCoreNLP;
import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.TreeCoreAnnotations;
import edu.stanford.nlp.trees.TreeReader;
import edu.stanford.nlp.util.CoreMap;

import java.io.StringWriter;
import java.util.ArrayList;
import java.util.List;
import java.util.Properties;

/**
 * Contains an analysis of a text
 */
public class Decomposition {


    public static final Label MARKER_LAST_WORD_OF_PHRASE = new StringLabel("endOfPhrase");


    //private List<Tree> sentencesPartsOfSpeech;
    private final Annotation document;

    ArrayList<String> mutationDescriptions = new ArrayList<String>();


    public Decomposition(String text) {
        Properties properties = new Properties();
        properties.setProperty("annotators", "tokenize, ssplit, pos, lemma, ner, parse");
//        properties.setProperty("annotators", "tokenize, ssplit, pos, lemma, ner, parse, dcoref, quote, regexner");
//        properties.setProperty("annotators", "tokenize, ssplit, pos, lemma, ner, parse, dcoref, sentiment, natlog, cdc, gender, depparse, truecase, relation, quote, entitymentions");
        StanfordCoreNLP pipeline = new StanfordCoreNLP(properties);
        document = new Annotation(text);
        pipeline.annotate(document);
    }

    public Decomposition(List<CoreMap> docMaps) {
        document = new Annotation(docMaps);
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

    public ArrayList<Object>  getEntities() {
        List<CoreMap> sentences = document.get(CoreAnnotations.SentencesAnnotation.class);
        ArrayList<Object> entities = new ArrayList<>();
        Object ner;
        for (CoreMap sentence : sentences) {

            for (CoreLabel token : sentence.get(CoreAnnotations.TokensAnnotation.class)) {
                ner = token.get(CoreAnnotations.NamedEntityTagAnnotation.class);
                if (!ner.equals("O")) {
                    entities.add(token.get(CoreAnnotations.TextAnnotation.class));
                    continue;
                }
            }
        }

        return entities;
    }

    public void addMutationDescription(String desc){
        if (desc != null)
            mutationDescriptions.add(desc);
    }

    public static String getRoughRealization(Tree node){
        StringWriter writer = new StringWriter();
        for (Tree tree: node.getLeaves()){
            writer.write(tree.value());
            writer.write(' ');
        }
        return writer.toString();
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



