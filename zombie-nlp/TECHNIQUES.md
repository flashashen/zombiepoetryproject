

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