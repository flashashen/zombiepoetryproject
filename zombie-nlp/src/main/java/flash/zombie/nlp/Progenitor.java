package flash.zombie.nlp;

import edu.stanford.nlp.pipeline.Annotation;
import edu.stanford.nlp.trees.*;
import edu.stanford.nlp.trees.tregex.TregexMatcher;
import edu.stanford.nlp.trees.tregex.TregexPattern;
import edu.stanford.nlp.util.CoreMap;
import edu.stanford.nlp.util.StringUtils;

import java.io.*;
import java.util.ArrayList;
import java.util.List;

/**
 *
 *  This class represents the Zombie progenitor. It contains a decomposition of the original
 *  Zombie text and collection of mutations. The public method is simply attack(String text)
 *  which applies the mutations and generates the zombified text.
 *
 */
public class Progenitor {


    public void attack(String text, Incident transformation){

        Decomposition decomposition = new Decomposition(text);
        mutate(decomposition);
        recompose(decomposition, transformation);
    }




    private void mutate(Decomposition decomposition){

        // Apply all transformations
        for (Mutation mutation : mutations){
            decomposition.addMutationDescription(mutation.toString());
            mutation.mutate(decomposition); // mutate tree? or need to replace old tree with new?
        }

    }


    private void recompose(Decomposition decomposition, Incident transformation) {

        transformation.zombieMutations = decomposition.mutationDescriptions;
        transformation.zombieText = "";

        List<Object> entites = decomposition.getEntities();
        //System.out.print(entites);


        // Mark the last words of phrases to help with line breaks
        List<Tree> zombieParse = decomposition.getParse();
        for (Tree tree : zombieParse) {
            TregexMatcher m = endOfPhrasePattern.matcher(tree);
            while (m.findNextMatchingNode())
                if (m.getMatch().isPreTerminal()) {
                   // m.getMatch().getChild(0).setLabel(Decomposition.MARKER_LAST_WORD_OF_PHRASE);
                    m.getMatch().getChild(0).setScore(100);
                }
        }


        int characterCounter = 0;
        Tree lastNode = null;
        Tree nextNode = null;
        StringWriter stringWriterZombie = new StringWriter();
        Tree node;
        boolean newLine = false;

        for (Tree sentence : zombieParse) {

            // Traverse the tree in order
            Tree[] nodes = sentence.getLeaves().toArray(new Tree[0]);

            for (int i=0; i<nodes.length; i++) {

                node = nodes[i];
                if (!node.isLeaf()) continue;

                lastNode = (i>0) ? nodes[i-1] : null;
                nextNode = (i<nodes.length-1) ? nodes[i+1] : null;
                if (isComma(nextNode)) nextNode = null;

                if (isComma(node)) {
                    // Ignore most commas but replace a few with em-dash
                    if (characterCounter > 5 && characterCounter < 25 && Math.random()*100 >= 100-20)
                        stringWriterZombie.append(" --");
                    else
                        // ignore
                        continue;
                }

//                else if (isTerminal(node)){
//                    //newLine = true;
//                    stringWriterZombie.append(node.value());
////                    if (characterCounter > 35) {
////                        newLine = true;
//                }

                else if (isPunctuation(node)){
                    // semi-colon, colon .. what else?
                    stringWriterZombie.append(node.value());
                }

                else {

                    // Assure capitalization is correct
                    if (entites.contains(node.value()) || lastNode == null || isTerminal(lastNode))
                        node.setValue(StringUtils.capitalize(node.value()));
                    else
                        node.setValue(node.value().toLowerCase());

                    stringWriterZombie.append(' ');

                    stringWriterZombie.append(node.value());
                    characterCounter += node.value().length();

                }

                if (newLine(lastNode, node, nextNode, characterCounter)){
                    // stringWriterZombie.append("\n");
                    String zombieLine = stringWriterZombie.toString();
                    transformation.zombieText += zombieLine;
                    transformation.zombieTextLines.add(zombieLine);
                    stringWriterZombie = new StringWriter();
                    characterCounter = 0;
                }
            }
        }

        // Add any text leftover
        if (characterCounter > 0) {
            String zombieLine = stringWriterZombie.toString();
            transformation.zombieText += zombieLine;
            transformation.zombieTextLines.add(zombieLine);
        }

    }




    private boolean isComma(Tree node){
        return (node != null && ",".equals(node.value()));
    }

    private boolean isPunctuation(Tree node){
        return (node != null && StringUtils.isPunct(node.value()));
    }

    private boolean isTerminal(Tree node){

        if (node == null) return false;

        return ".".equals(node.value())
                || "!".equals(node.value())
                || "?".equals(node.value());
    }

    private boolean isEndOfPhrase(Tree node){
        return (node != null && node.score() > 0);
    }


    private static final int LINE_LENGTH_UPPER_BOUND = 35;
    private static final int LINE_LENGTH_LOWER_BOUND = 25;
    private static final int LINE_LENGTH_SUFFICIENT = 30;

    private boolean newLine(Tree lastNode, Tree thisNode, Tree nextNode, int characterCounter){

        if (isPunctuation(nextNode))
            return false;

        if (characterCounter > LINE_LENGTH_UPPER_BOUND) {
            return true;
        }

        // If the line is will be made too long by a very long word, then break now
        if (characterCounter > LINE_LENGTH_SUFFICIENT && nextNode != null && nextNode.value().length() > 10) {
            return true;
        }

        // Break on terminal punctuation
        if (characterCounter > LINE_LENGTH_SUFFICIENT && isTerminal(thisNode)) {
            return true;
        }

        // If the line is likely to end in a low value word (a, the, etc), then break now
        if (characterCounter > LINE_LENGTH_SUFFICIENT && nextNode != null && nextNode.value().length() < 4) {
            return true;
        }

        // If this node is the end of a phrase then break as long as lower bound is reached
        if (characterCounter > LINE_LENGTH_LOWER_BOUND && isEndOfPhrase(thisNode)) {
            return true;
        }

        return false;
    }


    public Progenitor() {
        init();
    }

    private void init() {

        // Pre-analyze the progenitor poem for use by mutation objects
        progenitorDecomposition = new Decomposition(ZOMBIE);

        mutations = new ArrayList<>();
        mutations.add(new MutateSwapPPWithSibling(20, progenitorDecomposition));
        mutations.add(new MutateReplaceNNFromProgenitor(70, progenitorDecomposition));

//        BufferedReader br = null;
//        try {
//
//            Treebank tb = new DiskTreebank(new TreeReaderFactory() {
//                public TreeReader newTreeReader(Reader in) {
//                    return new PennTreeReader(in, new LabeledScoredTreeFactory(),
//                            new NPTmpRetainingTreeNormalizer());
//                }});
//            tb.loadPath("~/zombie_ride_along.txt.out");
//
//            new Annotation()
//
//
//            ArrayList<CoreMap> doc = new ArrayList<>();
//            for (Tree t; (t = tr.readTree()) != null; ) {
//                Trees.convertToCoreLabels(t);
//                doc.add(t);
//            }
//    } catch (Exception e) {
//        e.printStackTrace();
//    }

  //  progenitorDecomposition = new Decomposition(ZOMBIE);




    }





    public Decomposition getDecomposition(){
        return progenitorDecomposition;
    }


    private static final TregexPattern endOfPhrasePattern = TregexPattern.compile("__ (>>- VP |  >>- NP) $,, __");

    private Decomposition progenitorDecomposition;
    private List<Mutation> mutations;
   // private final String ZOMBIE = "Another town, another attack: Shots, then a show of conflagration. Blood rushes from our limbs, grooving the old channels, pooling hearts and minds. [Our Zombie Life] We bring to our bright screens our heat and our tears, proclaiming, as one, the suddenness of our pain, pleading to let some good be born of this. Buy my book, this one quickly shares, which alone might console and explain. The rest of us decide, without conviction, not to chirp a word. Is this innocence, surviving at the cost of mind? The country, still, is better, where blackbirds shawl the treetops, mimic the huffing wind. At night, the scent of skunk slices clean through the walls to where dreams spool and roll in bellies that growl and burst";

    private final String ZOMBIE = "Zombie Ride-Along\n" +
            "Another town, another attack:\n" +
            "Shots, then a show of conflagration.\n" +
            "Blood rushes from our limbs, grooving [Our Zombie Life]\n" +
            "the old channels,\n" +
            " pooling hearts and minds.\n" +
            "We bring to our bright screens our heat\n" +
            "and our tears, proclaiming together\n" +
            "the suddenness of our pain, pleading\n" +
            "to let some good be born of this.\n" +
            "Buy my book, this one quickly shares,\n" +
            "which alone might console and explain.\n" +
            "The rest of us decide, without\n" +
            "conviction, not to chirp a word.\n" +
            "Is this innocence, surviving\n" +
            "at the cost of mind?\n" +
            " The country,\n" +
            "still, is better, where blackbirds shawl\n" +
            "the treetops, mimic the huffing wind.\n" +
            "At night, the scent of skunk slices\n" +
            "clean through the walls to where dreams spool\n" +
            "and roll in bellies that growl and burst.\n" +
            "••• •••\n" +
            "Confess, they’ve rubbed off on you, these states\n" +
            "of drenched things which teach how little\n" +
            "there is that easily floats, how few\n" +
            "of us can resist a new regime. [Way Down and Out]\n" +
            "Once on this very road you saw,\n" +
            "just beyond the telephone lines,\n" +
            "a funnel cloud touch down. Then it passed\n" +
            "and you were safe, both of you churning\n" +
            "some other bit of earth, writing\n" +
            "yourselves in the book of common\n" +
            "sorrows, a mass market that falls\n" +
            "to pieces when it meets water. \n" +
            "Nowadays, you venture out in search\n" +
            "of soaked birds that for the moment\n" +
            "cannot fly. The feral cats would feast,\n" +
            "if they could stand the rain. Listen,\n" +
            "even the wipers like to complain.\n" +
            "••• •••\n" +
            "Had you driven along this road\n" +
            "when you were younger, you might have found\n" +
            "these scenes ludicrous and sad. You would\n" +
            "have driven fast. Some part of you\n" +
            "wouldn’t want to acknowledge what\n" +
            "you were seeing, what you failed to see.\n" +
            "You would have feared them, all the known\n" +
            "unknowns of your trip now.\n" +
            " You’re south\n" +
            "of Clarksdale, chasing a storm, those bands\n" +
            "of Mississippi gray which promise\n" +
            "to chaperone your journey back home,\n" +
            "slowing any return to your world.\n" +
            "••• •••\n" +
            "Honestly, I don’t know where to go\n" +
            "from here. It’s not a matter of will.\n" +
            "The muscles impel, mere reflex, [Caw]\n" +
            "probably, vestige of parent fear\n" +
            "encoded and passed down.\n" +
            " Sinew\n" +
            "and pearly-white teeth are fine gifts\n" +
            "and well worth showing off. Fast feet\n" +
            "are not. This, friend, is where we are.\n" +
            "Alluvial soil, detrital dirt,\n" +
            "turning world. Even when the levees\n" +
            "more or less hold, the earth is shifty.\n" +
            "Trails, roads, even whole towns vanish,\n" +
            "leaving only the metal which rusts\n" +
            "but remains, roofs and gins that collapse\n" +
            "on themselves, glinting in the sun.\n" +
            "Further out, solitary hardwoods\n" +
            "by creek beds dagger the landscape,\n" +
            "arbitrary, monolithic\n" +
            "monuments. Are they markers, scrawled\n" +
            "history, or shade for lean lunches?\n" +
            "Here, we plant saplings for the dead\n" +
            "and farm to the doors of old houses.\n" +
            "Here, our quickness of mind brings us\n" +
            "burgers and fries, and a bit of luck.\n" +
            "••• •••\n" +
            "Once the story ended, you might\n" +
            "go back and do anything, kill\n" +
            "the innocents you had set free. [Free Play]\n" +
            "What else?\n" +
            " Well, it was mostly that.\n" +
            "Nights, then days and nights, crafting a verb\n" +
            "from your loneliness, tensing at\n" +
            "creaks in the hall. Against walls, you\n" +
            "rounded them up, pixel by pixel,\n" +
            "taking your time, then dropping them,\n" +
            "one by one. Writhing on their stomachs\n" +
            "at what was not your feet, did they\n" +
            "say a single word? Only later,\n" +
            "when, married to your sleep, you lived out\n" +
            "in less tangible worlds fantasies\n" +
            "for which you had trained. Even there,\n" +
            "you found some doors would not open.\n" +
            "••• •••\n" +
            "The downtown strip is too quiet.\n" +
            "It’s an hour before lunch, fall\n" +
            "harvest time. Small piles of soy beans dot [Hot Sauce]\n" +
            "the roadside, spill-off from trucks; wisps\n" +
            "of cotton bandage the bottoms\n" +
            "of abandoned buildings. Movement.\n" +
            "The bars of the post office door\n" +
            "swing out. Two girls who ought to be\n" +
            "in school head toward an empty house. \n" +
            "You’re walking north on Fava Street,\n" +
            "named for a family who set up\n" +
            "shop here, running a grocery store\n" +
            "and a grill, the one building lit\n" +
            "on your side of the street; the one door\n" +
            "that grates and swings. You are a stranger,\n" +
            "sight to see. The woman behind\n" +
            "the register cannot contain\n" +
            "her surprise before her face goes flat,\n" +
            "a shield. You look away, look around,\n" +
            "as your friend starts talking. She points you\n" +
            "to the tables in the back. A pink\n" +
            "glow from overhead lights shines through\n" +
            "jars of pig’s feet, pickled in their brine.\n" +
            "You order a burger, just in time.\n" +
            "No sooner has your patty hit\n" +
            "the grill than the lunch rush spills in.\n" +
            "Workers fill the place for the chili\n" +
            "they’ve been smelling for blocks. Your eyes plead\n" +
            "“feed them first,” but she won’t have it.\n" +
            "Neither will they. The world rarely fails\n" +
            "to show you how mean and small you are.\n" +
            "She hands you one of the best burgers\n" +
            "you have eaten. When you stand to leave,\n" +
            "the young men give you too-wide a berth,\n" +
            "the kind of deference the bosses\n" +
            "must not notice after a while.\n" +
            "••• •••\n" +
            "Does doubt live in this world you have won?\n" +
            "Where would it hide? Behind those closed doors,\n" +
            "under lines of horizon, beyond\n" +
            "the distant spaces which call you home\n" +
            "and promise the busted mystery\n" +
            "of the long and open road? My God,\n" +
            "what have you done? What will you become?\n" +
            "I was not myself then; I am not\n" +
            "me now.\n" +
            " The last image you take \n" +
            "from this place is outside the largest\n" +
            "house in town. A straw militia man\n" +
            "holds a rifle on his shoulder\n" +
            "and sports a child’s helmet. Beside him\n" +
            "sits a guillotine and small cannon.\n" +
            "Halloween? Sheets curtain the windows\n" +
            "and as you pass, you think you see\n" +
            "(Is it a wish?) a hand pull back\n" +
            "an upstairs sheet. You slow,\n" +
            " but don’t stop\n" +
            "until the car breaks down south of town.\n" +
            "Suddenly, you’ve got more time to kill.\n" +
            "••• •••\n" +
            "So how do I share with yours and mine\n" +
            "this particular breeze? At the start,\n" +
            "everyone seemed shiny and flat,\n" +
            "sheets upon sheets. Perhaps our deaths [Selfie]\n" +
            "alone gave us depth, and this flatness,\n" +
            "this sheen, we named hunger. In time, it\n" +
            "assumed a leadership position\n" +
            "among us, our holy mother\n" +
            "of movement.\n" +
            " (Now, hold on a sec,\n" +
            "before you get the wrong idea.\n" +
            "Let me segue, let me keep you\n" +
            "since I’ve got you.\n" +
            " Remember those\n" +
            "B-sides of your youth, how you felt\n" +
            "sorry for those songs, sad ballasts\n" +
            "to siblings who stayed out late, climbing\n" +
            "the charts? They float in our oceans now,\n" +
            "fresh expanding islands that mean\n" +
            "we wait for nothing but our deaths.\n" +
            "How will we know it when it comes\n" +
            "for us? We’re rolling, B-sides and all.)\n" +
            "••• •••\n" +
            "The tow truck arrives from somewhere else,\n" +
            "its owner a teacher at the high school, \n" +
            "which he points out. A wooden sign [Mound Bayou]\n" +
            "tells you the town is the oldest\n" +
            "African-American settlement\n" +
            "in the country, but you won’t see this\n" +
            "until it’s in your rearview mirror.\n" +
            "The year of founding marks the place\n" +
            "as one of the longest lasting\n" +
            "interior towns, a colony\n" +
            "founded by a freed slave. Of course,\n" +
            "the whites soon tried to buy it back,\n" +
            "returning the farmers to the fates\n" +
            "they’d fled.\n" +
            " What desperation led them\n" +
            "to this spot? Even now that the hard\n" +
            "work of cultivation has long been done,\n" +
            "you can see how inhospitable\n" +
            "it must have been. Swamp and forest\n" +
            "and nothing for miles. Perhaps that’s it—\n" +
            "a spot miles from the real dangers.\n" +
            "(You’re not more than twenty minutes\n" +
            "from the river, but this thought does not\n" +
            "console. Your resolve to do justice\n" +
            "to this place pools in the wet heat.)\n" +
            "••• •••\n" +
            "Like almost every small town, this one\n" +
            "sports cosmetic touches, lime and pink\n" +
            "building fronts, but it’s deeply asleep. [Shut-eye]\n" +
            "Those lucky enough are elsewhere,\n" +
            "the rest have hidden themselves away.\n" +
            "Though this time of year it would take\n" +
            "a hurricane to cool things off,\n" +
            "you happen to have one coming,\n" +
            "an easy thought for someone like you—\n" +
            "This is someone’s home.\n" +
            "••• •••\n" +
            " Mute the voice.\n" +
            "You ask for guidance and I give\n" +
            "you platitudes, a knitted brow. [G.P.S.]\n" +
            "Latitudes? Attitudes. Our course—\n" +
            "a meandering, mending stitch\n" +
            "across the fair countryside. To those\n" +
            "standing still, the pleasures are obscured.\n" +
            "It takes, almost, a narrator:\n" +
            "They’ll sit awhile here instead of there.\n" +
            "They’ll trade those lights for whatever\n" +
            "is on your flashing screen.\n" +
            " Who stops\n" +
            "anymore for just a drink? Only\n" +
            "such travelers as we. We alone.\n" +
            "Recalculating….Find the route\n" +
            "to that dive that’s known for the staff\n" +
            "who toss hungry guests their dinner rolls.\n" +
            "They shoot across the room like stars.\n" +
            "From the roadside, a sign yells at you\n" +
            "to Repent!, but you are too far gone.\n" +
            "Off-road, a small graveyard beckons,\n" +
            "where Sweet little Sammy lies, dead\n" +
            "before he could crawl. His foot stone\n" +
            "is a tree trunk that must have sprouted\n" +
            "and fallen long after young Sammy.\n" +
            "The ground is higher here, though not\n" +
            "by much. Your friend tells you these plots\n" +
            "are all over, hidden by brush,\n" +
            "a gentle kind of forgetfulness.\n" +
            "Your head swims with the names of places\n" +
            "sleeping Sammy never learned to say.\n" +
            "••• •••\n" +
            "There is a sweet life. But obtained\n" +
            "by you and me? Roadside, the scent’s\n" +
            "so strong you think it must be something\n" +
            "placed and tended, something pruned and plucked. [Honeysuckle]\n" +
            "They like fences and poles, but farther\n" +
            "and soon there won’t be fences and poles,\n" +
            "just fields between solitary trees. \n" +
            "Do you remember? We combed the fence\n" +
            "and sowed the yard with petals; school\n" +
            "was out and you felt old at ten.\n" +
            "I’d forgotten the scent was so strong,\n" +
            "but the taste on my tongue stuck with me.\n" +
            "••• •••\n" +
            "You reach the light where two students\n" +
            "died last year, struck on their way to class\n" +
            "by a patrol car in fast pursuit. [Shall We Pray]\n" +
            "You remember them as you pass\n" +
            "and think how treacherous a road\n" +
            "this roa\n" +
            "d can be, mostly at night\n" +
            ",\n" +
            "when the brightness of your headlights\n" +
            "only serve\n" +
            "s to remind you how much\n" +
            "you’re not seeing. You dream of it\n" +
            "sometimes, driving straight into an F5,\n" +
            "stalled truck\n" +
            ", or family of deer\n" +
            "surfacing out of the deep dark\n" +
            "so fast there’s nothing to do but sigh\n" +
            "and go limp. When the impact wakes you\n" +
            ",\n" +
            "you find you cannot move.\n" +
            " It’s late\n" +
            "morning\n" +
            ". The old folk have gathered\n" +
            "around tables in their yards. It seems\n" +
            "every building’s boarded but\n" +
            "a church\n" +
            "and the convenience store. A man\n" +
            "in blackened overalls crosses\n" +
            "the street. You think he must be younger\n" +
            "than he looks because he looks too old\n" +
            "to be alive. He’s picked up a bike\n" +
            "from the gutter, a girl’s bike, purple\n" +
            "with a white basket tied to the front.\n" +
            "He hunches as he rides, so his knees\n" +
            "almost reach his chin. He has not looked\n" +
            "in\n" +
            "your direction and you can’t take\n" +
            "your eyes off him until the road\n" +
            "curbs him from your sight. You wonder\n" +
            "what the preachers tell their flocks, frying\n" +
            "on folding chairs in the Sunday heat.\n" +
            "Who’s hovering over that fed field? \n" +
            "••• •••\n" +
            "You were beside yourselves with rage.\n" +
            "You’d driven for hours, a straight line\n" +
            "across the top of your map. The wheel [U.F.O]\n" +
            "you gripped had warped in the long silence.\n" +
            "It was the way they nimbly moved\n" +
            "that caught her eye, the way they blinked\n" +
            "in the sky as if they were the points\n" +
            "of needles stitching a black skein\n" +
            "of lullabies. Later, against\n" +
            "her stiff pillow, she went to that couch\n" +
            "she kept in the safe room of her mind,\n" +
            "watching her grandmother gently work\n" +
            "in front of her father’s fire.\n" +
            " What\n" +
            "were they showing you by poking through\n" +
            "that night if not the effort it takes\n" +
            "to keep together our torn world?\n" +
            "She wanted error, the thread dropped low\n" +
            "enough to carry her back up,\n" +
            "so she might surface to newness,\n" +
            "having tied off her life down below.\n" +
            "••• •••\n" +
            "Now you’re north of Vicksburg. The road\n" +
            "is here as it’s always been, two-lanes\n" +
            "through the white and chocolate fields, [A Kennedy Came\n" +
            "the greens of rice and soy and corn. through Here\n" +
            "You pass a patch ribboned with flowers, with Tears in His\n" +
            "volunteers sprung up in orderly rows. Eyes]\n" +
            "Your friend and guide says he remembers\n" +
            "riding through these farms as they burned,\n" +
            "bands of orange fire, the black smoke\n" +
            "funneling out.\n" +
            " “What’s that,” you ask,\n" +
            "“at the field’s edge.”\n" +
            " “A boll-weevil trap.”\n" +
            "Sounds like a song. An old, sad song.\n" +
            "The place seems two-dimensional\n" +
            "against the gray sky, a triptych \n" +
            "of columns, cell tower, and school,\n" +
            "the grass hip-high on its roof. You feel\n" +
            "vaguely guilty, but everyone leaves.\n" +
            "You stop for a stretch, but don’t see it—\n" +
            "the sparkling ground, glitter of glass\n" +
            "from houses that were not built to last.\n" +
            "••• •••\n" +
            "That old store is just the kind of place\n" +
            "you like, even before you see\n" +
            "the sign marking it as the site [Onward]\n" +
            "of Roosevelt’s “Teddy Bear Hunt.”\n" +
            "The porch is smiling broadly, wood\n" +
            "panels stretching back down to the earth.\n" +
            "A group of hunters greet you, but\n" +
            "you know so little you cannot say\n" +
            "whether they’re on their way to bed\n" +
            "or blind.\n" +
            " Inside, you feel the chill.\n" +
            "You used to find 16 oz. bottles\n" +
            "by the road near your house and bring them\n" +
            "to this very store when it was set\n" +
            "deep in the Appalachian mountains\n" +
            "where you grew up. It even has\n" +
            "Mallo-Cups, which cost you four bottles.\n" +
            "••• •••\n" +
            "Do not look to the sky, for nothing\n" +
            "written there will be of any help.\n" +
            "Clouds do not conspire with the wind. [Chem Trails]\n" +
            "Halfway to heaven, they are heedless\n" +
            "palm prints, great nothing’s heavy-handed\n" +
            "marbling of the world.\n" +
            " The church points\n" +
            "its golden finger straight to God.\n" +
            "It seems angry, but it might be\n" +
            "your mood. It looks too accustomed\n" +
            "to the hard work of ownership.\n" +
            "At the stoplight, the thought you’ve buried\n" +
            "since you began this trip suspires \n" +
            "to the surface of your mind. It’s all\n" +
            "for you. This happened so you might\n" +
            "see it this very moment. The light\n" +
            "changes; the finger’s done its work.\n" +
            "••• •••\n" +
            "When it comes upon us, will we think\n" +
            "we’re nowhere near our destination?\n" +
            "Deep blues—the sky is like a spit-shined [Original Force]\n" +
            "china dish above the fat, flat lines\n" +
            "of our sight. Smells like someone died,\n" +
            "but it’s only the fields.\n" +
            " Oh, that’s\n" +
            "a family plot. You can tell because\n" +
            "the headstones still lean. The others\n" +
            "got wood, which went faster back to dust.\n" +
            "Port Gibson to Natchez, Natchez\n" +
            "to Dolorosa, where the road\n" +
            "swerves out from the river, something\n" +
            "keeping these two from straying\n" +
            "too far away from one another.\n" +
            "History, you suppose. You’re close\n" +
            "to the border, and well on your way.\n" +
            "••• •••\n" +
            "We are photons shooting deep in space\n" +
            "but are we carrying on as waves\n" +
            "or particles? It all depends\n" +
            "on if we’re being watched.\n" +
            " Old news, [Turn the Dial]\n" +
            "What’s strange is that some other minds\n" +
            "now think we will have decided\n" +
            "what we will become before we reach\n" +
            "the place we are or are not watched.\n" +
            "Let that settle in enough to feel\n" +
            "the staccato-thumping of your heart,\n" +
            "clutch of your blood revving the world\n" +
            "that rushes by at your fingertips.\n" +
            "What else moves you like this? The skunk\n" +
            "that crossed your path and whirled? Or was he \n" +
            "a scorpion? That bird astride\n" +
            "the yellow lines—will it become\n" +
            "itself and fly?\n" +
            " Do our vanished loves\n" +
            "choose to comfort or divide us\n" +
            "when they let themselves be seen? Angels\n" +
            "and devils both have wings. Both can soar.\n" +
            "••• •••\n" +
            "Most times, the truckers remember they\n" +
            "just want to get free, somewhere else\n" +
            "and new. This is one of their stories… [Breaker, Breaker,\n" +
            "Bedtime Story]\n" +
            "Like many, to earn money, the girl\n" +
            "cleaned houses with many rooms. One house,\n" +
            "especially, pleased her, because\n" +
            "it faced east, and she loved the light\n" +
            "that filled the place, the way the dust\n" +
            "flashed when she snapped her rag. Each morning,\n" +
            "though, she found another room to clean,\n" +
            "as if at night a whole crew showed up\n" +
            "to enlarge the house, room by room.\n" +
            "Sunlight did not shine through the windows\n" +
            "of these new rooms and, before long,\n" +
            "she found rooms without windows at all,\n" +
            "just walls, ceilings, and floors covered\n" +
            "in the dust of their construction.\n" +
            "She worked faster, harder each day,\n" +
            "until, one afternoon, she came\n" +
            "upon a door, behind which she heard\n" +
            "sounds of a different kind of labor,\n" +
            "whirring saw, and hammer and drill.\n" +
            "She opened the door to find a man\n" +
            "working feverishly. He was stooped\n" +
            "with age, although his hair and beard\n" +
            "were yellow with dust and bits of wood.\n" +
            "She saw, at once, the way his eyes sagged\n" +
            "with grief. “Please, the girl cried. “Please stop.\n" +
            "This house is large enough. Already,\n" +
            "we are too far from the light of day.\n" +
            "When I walk home, the sky is so red,\n" +
            "my hands bleed.” \n" +
            " “I will not,” snorted\n" +
            "the man.\n" +
            " “The dust gets everywhere,”\n" +
            "the girl cried. “It has blinded you\n" +
            "to the way things are.”\n" +
            " “I cannot stop,”\n" +
            "the man said, a bit more politely.\n" +
            "“I must make rooms and, so, you must\n" +
            "clean them.”\n" +
            " Desperate, the young girl\n" +
            "took the old man’s hand and led him\n" +
            "through the halls of the empty house\n" +
            "he had built. Finally, they arrived\n" +
            "at the windows she loved, but the sun\n" +
            "was shining on the other side\n" +
            "of the sky, softening everything,\n" +
            "for it was very late in the day.\n" +
            "The girl and the old man rested there\n" +
            "until morning and when the light,\n" +
            "the lovely, yellow light flooded\n" +
            "the rooms, the dust on the man’s clothes\n" +
            "and hair became shooting sparks of light\n" +
            ".\n" +
            "“I’m burning,” he cried.\n" +
            "“Take me back\n" +
            "to my work.”\n" +
            " And then it did seem\n" +
            "as if he were on fire, not like\n" +
            "a wick, which burns and burns, but a match\n" +
            "which flashes and is snuffed out. The girl,\n" +
            "in amazement, moved to the windows,\n" +
            "but she did not catch fire. She snapped\n" +
            "her rag, moving to the rhythm\n" +
            "she made, dancing for joy and sorrow\n" +
            "among\n" +
            "a sudden shower of stars\n" +
            ".\n" +
            "••• •••\n" +
            "There’\n" +
            "s the Ruins, and there’s the Fort\n" +
            "where rain\n" +
            "s pour. Your speech turns martial\n" +
            ".\n" +
            "[Self-guided Tour]\n" +
            "Days buisey scenes had past away.\n" +
            "The camp in sleeping silence lay.\n" +
            "\n" +
            "So wrote one James Addison Boyd,\n" +
            "who was later killed in battle,\n" +
            "as wave upon wave broke upon\n" +
            "and then swamped the earthworks. . Against\n" +
            "your will, you’ll feel it then, that old\n" +
            "southern ache, your birthright, tyranny\n" +
            "of pride disguised as civility.\n" +
            "You’ll feel it so strongly you’ll head back\n" +
            "in your mind to the ruins, those columns\n" +
            "connected by iron. An empire waist,\n" +
            "you joked, noting the Kudzu that grew\n" +
            "from their tops. Leaving, you saw the sign\n" +
            "which warned the whole thing was unstable.\n" +
            "••• •••\n" +
            "Dear blinds in fields beneath the road.\n" +
            "Are you nervous? Fiddle with the dial.\n" +
            "In time, the static sounds like code. [Lamech Killed Cain]\n" +
            "Tell me what you have not done. Confess,\n" +
            "did you chew or let the wafer rest\n" +
            "and grow wet and heavy on your tongue?\n" +
            "He was blind, but nevertheless\n" +
            "a great hunter. His loyal children\n" +
            "cleared before him his path and saw him\n" +
            "to his prey, but one day…\n" +
            " Happens\n" +
            "often here. Entirely plausible,\n" +
            "because, you know, the horns, which may\n" +
            "have been given as punishment.\n" +
            "Did he smile? Did the heavens fill\n" +
            "with laughter? The original killer,\n" +
            "brought down by a blind hunter. Might’ve\n" +
            "been any one of us? Might still.\n" +
            "••• •••\n" +
            "You like them, you know it. And best\n" +
            "from the back of a truck.. Don’t worry,\n" +
            "there’s always one just up ahead. [Tamales]\n" +
            "Now that the thought sticks in your brain,\n" +
            "too, it isn’t going anywhere.\n" +
            "There’s our sign, that square of blue that pales \n" +
            "the sky. Take them right out of the shuck\n" +
            "with some sauce. Hot fuel for the mind,\n" +
            "which no one needs.\n" +
            " It’s a zombie life\n" +
            "we lead. Friend, here’s where you get off.";

}
