
Welcome to the

#Zombie Poetry Project#



Starting May 1, 2016, we invite you to visit http://www.zombiepoetryproject.com to submit any English-language text into the open area provided. Using a set of language tools, this victim text will be syntactically matched with sections of the 500-line source poem, “Zombie Ride-Along.”  Elements of the source poem will then “infect” the victim text,  producing a new “zombified” poem. The process is intended to be dynamic, allowing you to refine the disease process by repeating the “zombification,” sentence by sentence, as often as you would like. Once you’re satisfied with your victim, you can submit your zombie poem to the growing anthology archived on the site under Incidents. 
 
 
 
This repo contains both a frontend wordpress site, www.zombiepoetryproject.com, as well as a spring-boot text 'zombification' application.

##Layout##

zombie-nlp: the text 'zombification' server. Uses Stanford core-nlp libs to parse an input text and output a list of sentences containing original text, zombie text, and some artifacts of the text analysis and transformation.

provision: ansible playbooks and roles for site setup and backup/restore

snapshots: intended just for backup but currently the home of the wordpress code


##Contributions##

This repo is not in a state suitable for callboration but the intention is to clean it up soon and then invite participation. The natural language processing piece is pretty basic yet but much is planned here and ideas will be most welcome. On the front end side, the enhanements anticipated will focus on showing the nlp artifacts and increasing the user interaction with the process of zombification. While much enhancement is needed technically, we hope the generated poetry will be interesting to users even in the first release.