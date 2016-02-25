

# text matching


## combine texts and look for coreference


## TregexPattern for pattern based searching on parse trees

not indexed so slower than tgrep but can work against arbitrary set of trees and is pipable

## convert verb tenses to match sub-trees

simpleng is known to have this. example at following link. Corenlp should have too but havne't seen it
http://stackoverflow.com/questions/9520501/how-do-you-get-the-past-tense-of-a-verb

## define valid subtree matches




## select/filter by line length. for example 8 to 33 characters looking for simlar number of syllables




# inputs

## lower limit on submission
- can do this via text box params



# poem generation

- total lines between 7 and 30  
- need original to be reconizable? must limit selected soure text to do this.

# rules
- preserve gerunds (VBZ) to preserve 'signature'
- Output line lenths between 8 to 40 character (grammar not affected/rel)
- omit some DT, 'all' , QP, (ex omit 10, sub 30)
- paramterize subs and ommissions by percentage  for noun, adj, adv (70, 70, 90)
- Don't omit or sub the preposition
- preserve PRP, PRP$
- % parameter would produce diff result even against same input


Boy, I got called home. More later, but after only ten minutes of playing I found a host of thoughts...

1. Verb phrases should remain consistent at least at the start.
2. Prepositional phrases can be rearranged within sentence if kept intact. 15% of the time.

NP PP phrases shouldn't be reordered. V PP phrases work well wehn reordred. Better when PP is not complex. in,of not good candidates

# direct descendent of VP right sister of VBZ not 'in' or 'to'
PP > VP $ VBZ !<< in !<< to
    
3. Appositive phrases can be rearranged within sentence if kept intact. 15% of the time. ex. Flash, one heck of a collaborator, coached Mike through the processes of downloading files.
4. Adjective phrases must appear inside the noun phrase it modifies, but we could reorder within the larger noun phrase. 10% of the time.
5. Adverbial phrases can be put before or after the verb they modify. 50% chance any adverbial phrase switches place???
6. One cool thing would be to switch simple subjects and verbs to change the nature of the sentence, so that, for example: “subject verb” became “verb subject” and, thus an implicit question. “You are good.” becomes “Are you good?” Might be fun to do this 10% of the time.


Annotations
'sentiment' : token.get(SentimentCoreAnnotations.SentimentClass.class) -> Neutral, ..
'natlog' : token.get(NaturalLogicAnnotations.PolarityAnnotation.class)  -> all 'up' but 'his uncanniness' both down. ?? 
'cdc' :   error "Must load a classifier when creating a column data classifier annotator"
'gender':  token.get(MachineReadingAnnotations.GenderAnnotation.class)  ->  null values
'truecase' : not useful.
'relation' : sentence.get(MachineReadingAnnotations.EntityMentionsAnnotation.class)  -> sentence wise list of entity mentions
           : sentence.get(MachineReadingAnnotations.RelationMentionsAnnotation.class) -> relations of above. works_for, lives_in.. .this does not work at all
'quote' :      this.document.get(CoreAnnotations.MentionsAnnotation.class)  -> per sentence and per doc entity mentions
'entitymentions' :  this.document.get(CoreAnnotations.QuotationsAnnotation.class) -> per sentence and per doc text that appears in quotes.

        