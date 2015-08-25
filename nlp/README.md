

Parsing / Analysis
----------------

***RELEX***
https://launchpad.net/relex

RelEx is an English-language dependency relationship extractor, built on the Carnegie-Mellon 
link parser. It can identify subject, object, indirect object and many other dependency 
relationships between words in a sentence. It also generates some advanced semantic relations, 
such as normalizing questions for question-answering.

As a "by-product", it also provides more basic functions, including entity detection, 
part-of-speech tagging, noun-number tagging, verb tense tagging, gender tagging, and so on.



***OpenNLP***
https://opennlp.apache.org/

supports the most common NLP tasks, such as tokenization, sentence segmentation, part-of-speech 
tagging, named entity extraction, chunking, parsing, and coreference resolution. These tasks 
are usually required to build more advanced text processing services. OpenNLP also includes 
maximum entropy and perceptron based machine learning.

Can be plugged into RELEX to improve analysis according a stray post on the interweb

Note: Most components in OpenNLP expect input which is segmented into sentences
    

Text Generation
----------------------

***NLGEN***
https://launchpad.net/nlgen

RelEx produces semantic relations (expressed as word tuples) 
from natural language text. NLGEN does the inverse, generating natural language text from 
semantic relations in the same format.

The general idea is to parse English text using RelEx, produce new semantic relations using, 
for example, probabilistic inference, and then generate natural language based on them.