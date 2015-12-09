# from stanford_corenlp_pywrapper import CoreNLP
#
#
# proc = CoreNLP("pos", corenlp_jars=["stanford/*"])
# print  proc.parse_doc("hello world. how are you?")




#
#   sentence -> tokens
#

import nltk
sentences = nltk.sent_tokenize("""
Another town, another attack:
Shots, then a show of conflagration.
Blood rushes from our limbs, grooving
the old channels, pooling hearts and minds. [Our Zombie Life]
We bring to our bright screens our heat
and our tears, proclaiming, as one,
the suddenness of our pain, pleading
to let some good be born of this.
""")


for sentence in sentences:
    words = nltk.word_tokenize(sentence)


    # tagged_words = nltk.pos_tag(words)
    # tree = nltk.ne_chunk(tagged_words)

    parser = nltk.ChartParser(groucho_grammar)
    # print ne_tagged_words
    tree.draw()



#
#     tokens -> parse tree
#

# sent = ['I', 'shot', 'an', 'elephant', 'in', 'my', 'pajamas']
# parser = nltk.ChartParser(groucho_grammar)
# for tree in parser.parse(sent):
#     print(tree)



#
# from nltk.corpus import treebank
# t = treebank.parsed_sents('wsj_0001.mrg')[0]
# t.draw()
