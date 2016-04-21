package flash.zombie.nlp;

import edu.stanford.nlp.ling.CoreAnnotations;
import edu.stanford.nlp.ling.CoreLabel;
import edu.stanford.nlp.ling.Label;
import edu.stanford.nlp.ling.StringLabel;
import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.pipeline.StanfordCoreNLP;
import edu.stanford.nlp.pipeline.TextOutputter;
import edu.stanford.nlp.trees.Tree;
import edu.stanford.nlp.trees.TreeCoreAnnotations;
import edu.stanford.nlp.util.CoreMap;
import flash.zombie.nlp.model.Sentence;

import java.io.*;
import java.util.ArrayList;
import java.util.IdentityHashMap;
import java.util.List;
import java.util.Properties;

/**
 * Contains an analysis of a text
 */
public class Decomposition {


    public static final Label MARKER_LAST_WORD_OF_PHRASE = new StringLabel("endOfPhrase");
//    public static final String SENTENCE_BOUNDARY_REGEX = "\\.|\\:|\\;|[!?]+";
    public static final String SENTENCE_BOUNDARY_REGEX = "\\.|:|;|--|[!?]+";


    //private List<Tree> sentencesPartsOfSpeech;
    private final Annotation document;

    ArrayList<String> mutationDescriptions = new ArrayList<String>();


    public static final StanfordCoreNLP pipeline;
    static {
        Properties properties = new Properties();
        properties.setProperty("annotators", "tokenize, ssplit, pos, lemma, ner, parse");
        properties.setProperty("ssplit.boundaryTokenRegex", SENTENCE_BOUNDARY_REGEX);
//        properties.setProperty("annotators", "tokenize, ssplit, pos, lemma, ner, parse, dcoref, sentiment, natlog, cdc, gender, depparse, truecase, relation, quote, entitymentions");
        pipeline = new StanfordCoreNLP(properties);
    }

    public Decomposition(String text) {

        // Remove junk / Normalize input
        text = text.replace("\\", "");


        document = new Annotation(text);
        pipeline.annotate(document);

        PrintWriter writer = null;
        try {

            File outputFile = File.createTempFile("victim_", ".json", new File("/tmp"));
            OutputStream fos = new BufferedOutputStream(new FileOutputStream(outputFile));
            TextOutputter.prettyPrint(document, fos, pipeline);
            fos.close();

//
//            writer = new PrintWriter("/tmp/the-file-name.txt", "UTF-8");
//            pipeline.prettyPrint(document, writer);
        } catch (Exception e) {
            e.printStackTrace();
        }

        // Un-capitalize the first word of each sentence so substitutions won't
        // put caps where we don't want them. The realization code will re-capitalize
        //List<Object> entites = progenitorDecomposition.getEntities();
        Decomposition.decapitalizeSentenceStarters(getParse());

    }


    public Decomposition(List<CoreMap> docMaps) {
        document = new Annotation(docMaps);
    }



//    public List<Tree> addTokenAnnotationsToNodes() {
//        List<CoreMap> sentences = document.get(CoreAnnotations.SentencesAnnotation.class);
//        List<Tree> parseTrees = new ArrayList(sentences.size());
//        for (CoreMap sentence : sentences) {
//            Tree tree = sentence.get(TreeCoreAnnotations.TreeAnnotation.class);
//            for (int i=0; i<tree.numChildren(); i++){
//                tree.getChild(0).set
//            }
//            Tree tree = sentence.set(TreeCoreAnnotations.TreeAnnotation.class);
//            parseTrees.add(tree);
//        }
//        return parseTrees;
//    }

    public List<Tree> getParse() {
        List<CoreMap> sentences = document.get(CoreAnnotations.SentencesAnnotation.class);
        List<Tree> parseTrees = new ArrayList(sentences.size());
        for (CoreMap sentence : sentences) {
            Tree tree = sentence.get(TreeCoreAnnotations.TreeAnnotation.class);
            parseTrees.add(tree);
        }
        return parseTrees;
    }

    public List<Sentence> getSentences() {
        List<CoreMap> stanfordSentences = document.get(CoreAnnotations.SentencesAnnotation.class);
        List<Sentence> sentences = new ArrayList(stanfordSentences.size());
        for (CoreMap standfordSentence : stanfordSentences) {
            Sentence sentence = new Sentence();
            sentence.setParseTree(standfordSentence.get(TreeCoreAnnotations.TreeAnnotation.class));
            sentences.add(sentence);
        }

        return sentences;
    }
    /**
     * Return a map of nodes that are a named entity. Later this will be a map of CoreLabels to
     * link the parse tree nodes with token data.
     *
     * @return - IdentityHashMap of Tree nodes that are an entity reference
     */

    IdentityHashMap<Tree, Object> entities = null;
    public IdentityHashMap<Tree, Object>  getEntities() {

        if (entities != null)
            return entities;

        List<CoreMap> sentences = document.get(CoreAnnotations.SentencesAnnotation.class);
        IdentityHashMap<Tree, Object> entities = new IdentityHashMap<>();
        Object ner;
        for (CoreMap sentence : sentences) {

            Tree tree = sentence.get(TreeCoreAnnotations.TreeAnnotation.class);
            List<Tree> leaves = tree.getLeaves();
            List<CoreLabel> tokens = sentence.get(CoreAnnotations.TokensAnnotation.class);
            for (int i=0; i<tokens.size(); i++ ){

                ner = tokens.get(i).get(CoreAnnotations.NamedEntityTagAnnotation.class);
                if (!ner.equals("O")) {
                    entities.put(leaves.get(i), null);
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

    public static void decapitalizeSentenceStarters(List<Tree> parse){
        Tree leaf;
        for (Tree sentence :  parse)  {
            leaf = sentence.getLeaves().get(0);
            System.out.println("uncapping first word of pregenitor. first word detected:  " + leaf.value());
            leaf.setValue(leaf.value().toLowerCase());
            System.out.println(" now:  " + leaf.value());
        }
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



