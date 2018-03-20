

# Zombie Poetry Project

 Some works from this project are being published!
 #### *Pocket Guide to Another Earth*, forthcoming from Dos Madres Press in 2018.

---

Visit http://www.zombiepoetryproject.com to submit any English-language text into the open area provided. Using a set of language tools, this victim text will be syntactically matched with sections of the 500-line source poem, “Zombie Ride-Along.”  Elements of the source poem will then “infect” the victim text,  producing a new “zombified” poem. The process is intended to be dynamic, allowing you to refine the disease process by repeating the “zombification,” sentence by sentence, as often as you would like. Once you’re satisfied with your victim, you can submit your zombie poem to the growing anthology archived on the site under Incidents. 
 

 

## Repo Layout

- src: Java source for the Spring-Boot NLP backend.Uses Stanford core-nlp libs to parse an input text and output a list of sentences containing original text, zombie text, and some artifacts of the text analysis and transformation.
- stanford: Play area for stanfod tregex tool
- zombie-infect: React app for the zombie [infection page](http://www.zombiepoetryproject.com/infect/#/)
- zombie-web: Wordpress [website](http://www.zombiepoetryproject.com/infect/#/)
- provision: ansible playbooks and roles for site setup and backup/restore


