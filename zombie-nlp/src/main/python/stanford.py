from stanford_corenlp_pywrapper import CoreNLP


proc = CoreNLP(
    corenlp_jars=["stanford/*"],
    annotators="tokenize, ssplit, pos, lemma, ner, entitymentions, parse, dcoref")
print  proc.parse_doc("""
Another town, another attack:
Shots, then a show of conflagration.
Blood rushes from our limbs, grooving
the old channels, pooling hearts and minds. [Our Zombie Life]
We bring to our bright screens our heat
and our tears, proclaiming, as one,
the suddenness of our pain, pleading
to let some good be born of this.
""")



