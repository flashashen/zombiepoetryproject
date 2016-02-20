
# Build

export JAVA_HOME=/Library/Java/JavaVirtualMachines/jdk1.8.0_66.jdk/Contents/Home


# Run

java -Xdebug -Xrunjdwp:transport=dt_socket,server=y,suspend=y,address=5005 -jar target/zombie-nlp-1.0-SNAPSHOT.jar



# NLP tools


## Stanford NLP CoreNLP (sophisticated, pre-trained models avail)


## NLTK python toolkit. (lacks dependency parse. other advanced features. Also is slow)

## spaCy - recent python (docs, api, and demo are nice and clean)
http://spacy.io/

## The best (apparently python wrapper for Stanford nlp)
https://github.com/brendano/stanford_corenlp_pywrapper

## Apache project for NLP clusterable, pluggable, spec based java/c++ framework
https://uima.apache.org/

## DKPRo - UIMA - recommended UIMA project by Standford
https://dkpro.github.io/dkpro-core/groovy/recipes/fully-mixed/


Semantic role labeling
- Shalmaneser
- Illinois Semantic Role Labeler


Named-entity recognition
- standford nlp
- OpenNLP
- GATE

Coreference resolution






#