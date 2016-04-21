package flash.zombie.nlp;

import flash.zombie.nlp.model.Incident;
import flash.zombie.nlp.model.Sentence;

import java.util.ArrayList;
import java.util.List;

/**
 *
 *  This class represents the Zombie progenitor. It contains a decomposition of the original
 *  Zombie text and collection of mutations. The public method is simply attack(Incident incident)
 *  which applies the mutations and generates the zombified text.
 *
 */
public class Progenitor {


    public void attack(Incident incident){

        Sentence victimSentence, zombieSentence;
        boolean forceZombification = true;

        // Decompose/Analyze the victim text
        if (incident.getVictim() == null) {
            forceZombification = false;
            Decomposition decomposition = new Decomposition(incident.victimText);
            incident.setVictim(decomposition.getSentences());
            incident.setZombie(new ArrayList<>(incident.getVictim().size()));
            for (Sentence sentence : incident.getVictim()){
                zombieSentence = new Sentence();
                zombieSentence.setAttack(true);
                incident.getZombie().add(zombieSentence);
            }
        }

        // Apply mutations, preserving the original victim a text and parse.
        for (int i=0; i<incident.getVictim().size(); i++) {

            victimSentence = incident.getVictim().get(i);
            zombieSentence = incident.getZombie().get(i);

            // first copy the victim parse tree into the zombie sentence
//            if (zombieSentence == null) {
//                zombieSentence = new Sentence();
//                zombieSentence.setAttack(true);
//                incident.getZombie().set(i, zombieSentence);
//            }

            // Then apply all mutations to the zombie sentence.
            if (zombieSentence.isAttack()) {
                zombieSentence.setParseTree(victimSentence.getParseTree().deepCopy());
                zombieSentence.setMutations(new ArrayList<>());
                zombieSentence.setText("");

                // Keep trying if no mutations result and if force flag is true. force flag should be true when zombification was selective.
                int j = 0;
                do {

                    for (Mutation mutation : mutations) {
                        mutation.mutate(zombieSentence);
                    }
                    zombieSentence.setAttack(false);
                    j++;
                } while (forceZombification
                        && (zombieSentence.getMutations() == null || zombieSentence.getMutations().size() == 0)
                        && j < 10);
            }
        }

//        for (Tree tree : decomposition.getParse()){
//            System.out.println(Decomposition.getRoughRealization(tree));
//        }


        // Realize zombie text
        incident.zombieText = "";
        Realizer realizer = new Realizer();
        incident.zombieText += realizer.realize(incident.getZombie());
    }








    public Progenitor() {
        init();
    }

    private void init() {

        // Pre-analyze the progenitor poem for use by mutation objects
        progenitorDecomposition = new Decomposition(ZOMBIE);


        mutations = new ArrayList<>();
        //mutations.add(new MutateSwapPPWithSibling(20, progenitorDecomposition));
        mutations.add(new MutateReplaceChildrenFromProgenitor(60, progenitorDecomposition));
        mutations.add(new MutateSimpleReplaceFromProgenitor("VBG", 60, progenitorDecomposition));
        mutations.add(new MutateSimpleReplaceFromProgenitor("VBD", 60, progenitorDecomposition));
        mutations.add(new MutateSimpleReplaceFromProgenitor("RB | RBR | RBS", 40, progenitorDecomposition));
        mutations.add(new MutateSimpleReplaceFromProgenitor("JJ | JJR | JJS", 40, progenitorDecomposition));
        mutations.add(new MutateReplaceFragFromSignatureZombieFrags(50, progenitorDecomposition));


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



    private Decomposition progenitorDecomposition;
    private List<Mutation> mutations;
   // private final String ZOMBIE = "Another town, another attack: Shots, then a show of conflagration. Blood rushes from our limbs, grooving the old channels, pooling hearts and minds. [Our Zombie Life] We bring to our bright screens our heat and our tears, proclaiming, as one, the suddenness of our pain, pleading to let some good be born of this. Buy my book, this one quickly shares, which alone might console and explain. The rest of us decide, without conviction, not to chirp a word. Is this innocence, surviving at the cost of mind? The country, still, is better, where blackbirds shawl the treetops, mimic the huffing wind. At night, the scent of skunk slices clean through the walls to where dreams spool and roll in bellies that growl and burst";


        //
        //      the side-bars were causing issues because they were bracketed and un-grammatical. Pull them out for now.
        //
        //  [Our Zombie Life]  [Caw]  [Way Down and Out]  [Free Play]  [Hot Sauce] [Selfie] [Mound Bayou]  [Shut-eye] [G.P.S.] [Honeysuckle] [Shall We Pray] [U.F.O] [Chem Trails] [Original Force] [Turn the Dial] [Breaker, Breaker, " +
        // [ Bedtime Story] [Lamech Killed Cain] [Tamales]


    private final String ZOMBIE = "Zombie Ride-Along " +
            "Another town, another attack: " +
            "Shots, then a show of conflagration. " +
            "Blood rushes from our limbs, grooving " +
            "the old channels, " +
            "pooling hearts and minds. " +
            "We bring to our bright screens our heat " +
            "and our tears, proclaiming together " +
            "the suddenness of our pain, pleading " +
            "to let some good be born of this. " +
            "Buy my book, this one quickly shares, " +
            "which alone might console and explain. " +
            "The rest of us decide, without " +
            "conviction, not to chirp a word. " +
            "Is this innocence, surviving " +
            "at the cost of mind? " +
            "The country, " +
            "still, is better, where blackbirds shawl " +
            "the treetops, mimic the huffing wind. " +
            "At night, the scent of skunk slices " +
            "clean through the walls to where dreams spool " +
            "and roll in bellies that growl and burst. " +
            "Confess, they’ve rubbed off on you, these states " +
            "of drenched things which teach how little " +
            "there is that easily floats, how few " +
            "of us can resist a new regime.  " +
            "Once on this very road you saw, " +
            "just beyond the telephone lines, " +
            "a funnel cloud touch down. Then it passed " +
            "and you were safe, both of you churning " +
            "some other bit of earth, writing " +
            "yourselves in the book of common " +
            "sorrows, a mass market that falls " +
            "to pieces when it meets water.  " +
            "Nowadays, you venture out in search " +
            "of soaked birds that for the moment " +
            "cannot fly. The feral cats would feast, " +
            "if they could stand the rain. Listen, " +
            "even the wipers like to complain. " +
            "Had you driven along this road " +
            "when you were younger, you might have found " +
            "these scenes ludicrous and sad. You would " +
            "have driven fast. Some part of you " +
            "wouldn’t want to acknowledge what " +
            "you were seeing, what you failed to see. " +
            "You would have feared them, all the known " +
            "unknowns of your trip now. " +
            " You’re south " +
            "of Clarksdale, chasing a storm, those bands " +
            "of Mississippi gray which promise " +
            "to chaperone your journey back home, " +
            "slowing any return to your world. " +
            "Honestly, I don’t know where to go " +
            "from here. It’s not a matter of will. " +
            "The muscles impel, mere reflex,  " +
            "probably, vestige of parent fear " +
            "encoded and passed down. " +
            " Sinew " +
            "and pearly-white teeth are fine gifts " +
            "and well worth showing off. Fast feet " +
            "are not. This, friend, is where we are. " +
            "Alluvial soil, detrital dirt, " +
            "turning world. Even when the levees " +
            "more or less hold, the earth is shifty. " +
            "Trails, roads, even whole towns vanish, " +
            "leaving only the metal which rusts " +
            "but remains, roofs and gins that collapse " +
            "on themselves, glinting in the sun. " +
            "Further out, solitary hardwoods " +
            "by creek beds dagger the landscape, " +
            "arbitrary, monolithic " +
            "monuments. Are they markers, scrawled " +
            "history, or shade for lean lunches? " +
            "Here, we plant saplings for the dead " +
            "and farm to the doors of old houses. " +
            "Here, our quickness of mind brings us " +
            "burgers and fries, and a bit of luck. " +
            "Once the story ended, you might " +
            "go back and do anything, kill " +
            "the innocents you had set free.  " +
            "What else? " +
            "Well, it was mostly that. " +
            "Nights, then days and nights, crafting a verb " +
            "from your loneliness, tensing at " +
            "creaks in the hall. Against walls, you " +
            "rounded them up, pixel by pixel, " +
            "taking your time, then dropping them, " +
            "one by one. Writhing on their stomachs " +
            "at what was not your feet, did they " +
            "say a single word? Only later, " +
            "when, married to your sleep, you lived out " +
            "in less tangible worlds fantasies " +
            "for which you had trained. Even there, " +
            "you found some doors would not open. " +
            "The downtown strip is too quiet. " +
            "It’s an hour before lunch, fall " +
            "harvest time. Small piles of soy beans dot " +
            "the roadside, spill-off from trucks; wisps " +
            "of cotton bandage the bottoms " +
            "of abandoned buildings. Movement. " +
            "The bars of the post office door " +
            "swing out. Two girls who ought to be " +
            "in school head toward an empty house.  " +
            "You’re walking north on Fava Street, " +
            "named for a family who set up " +
            "shop here, running a grocery store " +
            "and a grill, the one building lit " +
            "on your side of the street; the one door " +
            "that grates and swings. You are a stranger, " +
            "sight to see. The woman behind " +
            "the register cannot contain " +
            "her surprise before her face goes flat, " +
            "a shield. You look away, look around, " +
            "as your friend starts talking. She points you " +
            "to the tables in the back. A pink " +
            "glow from overhead lights shines through " +
            "jars of pig’s feet, pickled in their brine. " +
            "You order a burger, just in time. " +
            "No sooner has your patty hit " +
            "the grill than the lunch rush spills in. " +
            "Workers fill the place for the chili " +
            "they’ve been smelling for blocks. Your eyes plead " +
            "“feed them first,” but she won’t have it. " +
            "Neither will they. The world rarely fails " +
            "to show you how mean and small you are. " +
            "She hands you one of the best burgers " +
            "you have eaten. When you stand to leave, " +
            "the young men give you too-wide a berth, " +
            "the kind of deference the bosses " +
            "must not notice after a while. " +
            "Does doubt live in this world you have won? " +
            "Where would it hide? Behind those closed doors, " +
            "under lines of horizon, beyond " +
            "the distant spaces which call you home " +
            "and promise the busted mystery " +
            "of the long and open road? My God, " +
            "what have you done? What will you become? " +
            "I was not myself then; I am not " +
            "me now. " +
            " The last image you take  " +
            "from this place is outside the largest " +
            "house in town. A straw militia man " +
            "holds a rifle on his shoulder " +
            "and sports a child’s helmet. Beside him " +
            "sits a guillotine and small cannon. " +
            "Halloween? Sheets curtain the windows " +
            "and as you pass, you think you see " +
            "(Is it a wish?) a hand pull back " +
            "an upstairs sheet. You slow, " +
            " but don’t stop " +
            "until the car breaks down south of town. " +
            "Suddenly, you’ve got more time to kill. " +
            "So how do I share with yours and mine " +
            "this particular breeze? At the start, " +
            "everyone seemed shiny and flat, " +
            "sheets upon sheets. Perhaps our deaths  " +
            "alone gave us depth, and this flatness, " +
            "this sheen, we named hunger. In time, it " +
            "assumed a leadership position " +
            "among us, our holy mother " +
            "of movement. " +
            " (Now, hold on a sec, " +
            "before you get the wrong idea. " +
            "Let me segue, let me keep you " +
            "since I’ve got you. " +
            " Remember those " +
            "B-sides of your youth, how you felt " +
            "sorry for those songs, sad ballasts " +
            "to siblings who stayed out late, climbing " +
            "the charts? They float in our oceans now, " +
            "fresh expanding islands that mean " +
            "we wait for nothing but our deaths. " +
            "How will we know it when it comes " +
            "for us? We’re rolling, B-sides and all.) " +
            "The tow truck arrives from somewhere else, " +
            "its owner a teacher at the high school,  " +
            "which he points out. A wooden sign  " +
            "tells you the town is the oldest " +
            "African-American settlement " +
            "in the country, but you won’t see this " +
            "until it’s in your rearview mirror. " +
            "The year of founding marks the place " +
            "as one of the longest lasting " +
            "interior towns, a colony " +
            "founded by a freed slave. Of course, " +
            "the whites soon tried to buy it back, " +
            "returning the farmers to the fates " +
            "they’d fled. " +
            " What desperation led them " +
            "to this spot? Even now that the hard " +
            "work of cultivation has long been done, " +
            "you can see how inhospitable " +
            "it must have been. Swamp and forest " +
            "and nothing for miles. Perhaps that’s it— " +
            "a spot miles from the real dangers. " +
            "(You’re not more than twenty minutes " +
            "from the river, but this thought does not " +
            "console. Your resolve to do justice " +
            "to this place pools in the wet heat.) " +
            "Like almost every small town, this one " +
            "sports cosmetic touches, lime and pink " +
            "building fronts, but it’s deeply asleep. " +
            "Those lucky enough are elsewhere, " +
            "the rest have hidden themselves away. " +
            "Though this time of year it would take " +
            "a hurricane to cool things off, " +
            "you happen to have one coming, " +
            "an easy thought for someone like you— " +
            "This is someone’s home. " +
            " Mute the voice. " +
            "You ask for guidance and I give " +
            "you platitudes, a knitted brow.  " +
            "Latitudes? Attitudes. Our course — " +
            "a meandering, mending stitch " +
            "across the fair countryside. To those " +
            "standing still, the pleasures are obscured. " +
            "It takes, almost, a narrator: " +
            "They’ll sit awhile here instead of there. " +
            "They’ll trade those lights for whatever " +
            "is on your flashing screen. " +
            " Who stops " +
            "anymore for just a drink? Only " +
            "such travelers as we. We alone. " +
            "Recalculating….Find the route " +
            "to that dive that’s known for the staff " +
            "who toss hungry guests their dinner rolls. " +
            "They shoot across the room like stars. " +
            "From the roadside, a sign yells at you " +
            "to Repent!, but you are too far gone. " +
            "Off-road, a small graveyard beckons, " +
            "where Sweet little Sammy lies, dead " +
            "before he could crawl. His foot stone " +
            "is a tree trunk that must have sprouted " +
            "and fallen long after young Sammy. " +
            "The ground is higher here, though not " +
            "by much. Your friend tells you these plots " +
            "are all over, hidden by brush, " +
            "a gentle kind of forgetfulness. " +
            "Your head swims with the names of places " +
            "sleeping Sammy never learned to say. " +
            "There is a sweet life. But obtained " +
            "by you and me? Roadside, the scent’s " +
            "so strong you think it must be something " +
            "placed and tended, something pruned and plucked." +
            "They like fences and poles, but farther " +
            "and soon there won’t be fences and poles, " +
            "just fields between solitary trees.  " +
            "Do you remember? We combed the fence " +
            "and sowed the yard with petals; school " +
            "was out and you felt old at ten. " +
            "I’d forgotten the scent was so strong, " +
            "but the taste on my tongue stuck with me. " +
            "You reach the light where two students " +
            "died last year, struck on their way to class " +
            "by a patrol car in fast pursuit.  " +
            "You remember them as you pass " +
            "and think how treacherous a road " +
            "this road can be, mostly at night, " +
            "when the brightness of your headlights " +
            "only serves to remind you how much " +
            "you’re not seeing. You dream of it " +
            "sometimes, driving straight into an F5, " +
            "stalled truck, or family of deer " +
            "surfacing out of the deep dark " +
            "so fast there’s nothing to do but sigh " +
            "and go limp. When the impact wakes you, " +
            "you find you cannot move. " +
            " It’s late morning. The old folk have gathered " +
            "around tables in their yards. It seems " +
            "every building’s boarded but a church " +
            "and the convenience store. A man " +
            "in blackened overalls crosses " +
            "the street. You think he must be younger " +
            "than he looks because he looks too old " +
            "to be alive. He’s picked up a bike " +
            "from the gutter, a girl’s bike, purple " +
            "with a white basket tied to the front. " +
            "He hunches as he rides, so his knees " +
            "almost reach his chin. He has not looked " +
            "in your direction and you can’t take " +
            "your eyes off him until the road " +
            "curbs him from your sight. You wonder " +
            "what the preachers tell their flocks, frying " +
            "on folding chairs in the Sunday heat. " +
            "Who’s hovering over that fed field?  " +
            "You were beside yourselves with rage. " +
            "You’d driven for hours, a straight line " +
            "across the top of your map. The wheel   " +
            "you gripped had warped in the long silence. " +
            "It was the way they nimbly moved " +
            "that caught her eye, the way they blinked " +
            "in the sky as if they were the points " +
            "of needles stitching a black skein " +
            "of lullabies. Later, against " +
            "her stiff pillow, she went to that couch " +
            "she kept in the safe room of her mind, " +
            "watching her grandmother gently work " +
            "in front of her father’s fire. " +
            " What were they showing you by poking through " +
            "that night if not the effort it takes " +
            "to keep together our torn world? " +
            "She wanted error, the thread dropped low " +
            "enough to carry her back up, " +
            "so she might surface to newness, " +
            "having tied off her life down below. " +
            "Now you’re north of Vicksburg. The road " +
            "is here as it’s always been, two-lanes " +
            "through the white and chocolate fields, A Kennedy Came " +
            "the greens of rice and soy and corn. through Here " +
            "You pass a patch ribboned with flowers, with Tears in His " +
            "volunteers sprung up in orderly rows. Eyes " +
            "Your friend and guide says he remembers " +
            "riding through these farms as they burned, " +
            "bands of orange fire, the black smoke " +
            "funneling out. " +
            " “What’s that,” you ask, " +
            "“at the field’s edge.” " +
            " “A boll-weevil trap.” " +
            "Sounds like a song. An old, sad song. " +
            "The place seems two-dimensional " +
            "against the gray sky, a triptych  " +
            "of columns, cell tower, and school, " +
            "the grass hip-high on its roof. You feel " +
            "vaguely guilty, but everyone leaves. " +
            "You stop for a stretch, but don’t see it— " +
            "the sparkling ground, glitter of glass " +
            "from houses that were not built to last. " +
            "That old store is just the kind of place " +
            "you like, even before you see " +
            "the sign marking it as the site " +
             //[Onward] " +
            "of Roosevelt’s “Teddy Bear Hunt.” " +
            "The porch is smiling broadly, wood " +
            "panels stretching back down to the earth. " +
            "A group of hunters greet you, but " +
            "you know so little you cannot say " +
            "whether they’re on their way to bed " +
            "or blind. Inside, you feel the chill. " +
            "You used to find 16 oz. bottles " +
            "by the road near your house and bring them " +
            "to this very store when it was set " +
            "deep in the Appalachian mountains " +
            "where you grew up. It even has " +
            "Mallo-Cups, which cost you four bottles. " +
            "Do not look to the sky, for nothing " +
            "written there will be of any help. " +
            "Clouds do not conspire with the wind. " +
            "Halfway to heaven, they are heedless " +
            "palm prints, great nothing’s heavy-handed " +
            "marbling of the world. " +
            " The church points " +
            "its golden finger straight to God. " +
            "It seems angry, but it might be " +
            "your mood. It looks too accustomed " +
            "to the hard work of ownership. " +
            "At the stoplight, the thought you’ve buried " +
            "since you began this trip suspires  " +
            "to the surface of your mind. It’s all " +
            "for you. This happened so you might " +
            "see it this very moment. The light " +
            "changes; the finger’s done its work. " +
            "When it comes upon us, will we think " +
            "we’re nowhere near our destination? " +
            "Deep blues—the sky is like a spit-shined " +
            "china dish above the fat, flat lines " +
            "of our sight. Smells like someone died, " +
            "but it’s only the fields. " +
            " Oh, that’s " +
            "a family plot. You can tell because " +
            "the headstones still lean. The others " +
            "got wood, which went faster back to dust. " +
            "Port Gibson to Natchez, Natchez " +
            "to Dolorosa, where the road " +
            "swerves out from the river, something " +
            "keeping these two from straying " +
            "too far away from one another. " +
            "History, you suppose. You’re close " +
            "to the border, and well on your way. " +
            "We are photons shooting deep in space " +
            "but are we carrying on as waves " +
            "or particles? It all depends " +
            "on if we’re being watched. " +
            " Old news,  " +
            "What’s strange is that some other minds " +
            "now think we will have decided " +
            "what we will become before we reach " +
            "the place we are or are not watched. " +
            "Let that settle in enough to feel " +
            "the staccato-thumping of your heart, " +
            "clutch of your blood revving the world " +
            "that rushes by at your fingertips. " +
            "What else moves you like this? The skunk " +
            "that crossed your path and whirled? Or was he  " +
            "a scorpion? That bird astride " +
            "the yellow lines—will it become " +
            "itself and fly? " +
            " Do our vanished loves " +
            "choose to comfort or divide us " +
            "when they let themselves be seen? Angels " +
            "and devils both have wings. Both can soar. " +
            "Most times, the truckers remember they " +
            "just want to get free, somewhere else " +
            "and new. This is one of their stories…  " +
            "Like many, to earn money, the girl " +
            "cleaned houses with many rooms. One house, " +
            "especially, pleased her, because " +
            "it faced east, and she loved the light " +
            "that filled the place, the way the dust " +
            "flashed when she snapped her rag. Each morning, " +
            "though, she found another room to clean, " +
            "as if at night a whole crew showed up " +
            "to enlarge the house, room by room. " +
            "Sunlight did not shine through the windows " +
            "of these new rooms and, before long, " +
            "she found rooms without windows at all, " +
            "just walls, ceilings, and floors covered " +
            "in the dust of their construction. " +
            "She worked faster, harder each day, " +
            "until, one afternoon, she came " +
            "upon a door, behind which she heard " +
            "sounds of a different kind of labor, " +
            "whirring saw, and hammer and drill. " +
            "She opened the door to find a man " +
            "working feverishly. He was stooped " +
            "with age, although his hair and beard " +
            "were yellow with dust and bits of wood. " +
            "She saw, at once, the way his eyes sagged " +
            "with grief. “Please, the girl cried. “Please stop. " +
            "This house is large enough. Already, " +
            "we are too far from the light of day. " +
            "When I walk home, the sky is so red, " +
            "my hands bleed.”  " +
            " “I will not,” snorted the man. " +
            " “The dust gets everywhere,” " +
            "the girl cried. “It has blinded you " +
            "to the way things are.” " +
            " “I cannot stop,” " +
            "the man said, a bit more politely. " +
            "“I must make rooms and, so, you must " +
            "clean them.” " +
            " Desperate, the young girl " +
            "took the old man’s hand and led him " +
            "through the halls of the empty house " +
            "he had built. Finally, they arrived " +
            "at the windows she loved, but the sun " +
            "was shining on the other side " +
            "of the sky, softening everything, " +
            "for it was very late in the day. " +
            "The girl and the old man rested there " +
            "until morning and when the light, " +
            "the lovely, yellow light flooded " +
            "the rooms, the dust on the man’s clothes " +
            "and hair became shooting sparks of light. " +
            "“I’m burning,” he cried. " +
            "“Take me back " +
            "to my work.” " +
            " And then it did seem " +
            "as if he were on fire, not like " +
            "a wick, which burns and burns, but a match " +
            "which flashes and is snuffed out. The girl, " +
            "in amazement, moved to the windows, " +
            "but she did not catch fire. She snapped " +
            "her rag, moving to the rhythm " +
            "she made, dancing for joy and sorrow " +
            "among a sudden shower of stars. " +
            "There’s the Ruins, and there’s the Fort " +
            "where rains pour. Your speech turns martial. " +
//            "[Self-guided Tour]" +
            "Days buisey scenes had past away. " +
            "The camp in sleeping silence lay. " +
            "So wrote one James Addison Boyd, " +
            "who was later killed in battle, " +
            "as wave upon wave broke upon " +
            "and then swamped the earthworks. . Against " +
            "your will, you’ll feel it then, that old " +
            "southern ache, your birthright, tyranny " +
            "of pride disguised as civility. " +
            "You’ll feel it so strongly you’ll head back " +
            "in your mind to the ruins, those columns " +
            "connected by iron. An empire waist, " +
            "you joked, noting the Kudzu that grew " +
            "from their tops. Leaving, you saw the sign " +
            "which warned the whole thing was unstable. " +
            "Dear blinds in fields beneath the road. " +
            "Are you nervous? Fiddle with the dial. " +
            "In time, the static sounds like code. " +
            "Tell me what you have not done. Confess, " +
            "did you chew or let the wafer rest " +
            "and grow wet and heavy on your tongue? " +
            "He was blind, but nevertheless " +
            "a great hunter. His loyal children " +
            "cleared before him his path and saw him " +
            "to his prey, but one day… " +
            " Happens " +
            "often here. Entirely plausible, " +
            "because, you know, the horns, which may " +
            "have been given as punishment. " +
            "Did he smile? Did the heavens fill " +
            "with laughter? The original killer, " +
            "brought down by a blind hunter. Might’ve " +
            "been any one of us? Might still. " +
            "You like them, you know it. And best " +
            "from the back of a truck.. Don’t worry, " +
            "there’s always one just up ahead. " +
            "Now that the thought sticks in your brain, " +
            "too, it isn’t going anywhere. " +
            "There’s our sign, that square of blue that pales  " +
            "the sky. Take them right out of the shuck " +
            "with some sauce. Hot fuel for the mind, " +
            "which no one needs. " +
            " It’s a zombie life " +
            "we lead. Friend, here’s where you get off.";

}
