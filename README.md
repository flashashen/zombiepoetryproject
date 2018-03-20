

# Zombie Poetry Project

 Some works from this project are being published!
 #### *Pocket Guide to Another Earth*, forthcoming from Dos Madres Press in 2018.

---

Visit http://www.zombiepoetryproject.com to submit any English-language text into the open area provided. Using a set of language tools, this victim text will be syntactically matched with sections of the 500-line source poem, “Zombie Ride-Along.”  Elements of the source poem will then “infect” the victim text,  producing a new “zombified” poem. The process is intended to be dynamic, allowing you to refine the disease process by repeating the “zombification,” sentence by sentence, as often as you would like. Once you’re satisfied with your victim, you can submit your zombie poem to the growing anthology archived on the site under Incidents. 
 
---

### Website 
*/zombie-web*

Wordpress frontend


### Infection 
*/zombie-infect*

React [application](http://www.zombiepoetryproject.com/infect/#/) that handles the user interaction with the zombie text.


### Zombification service
*/src*

Spring-Boot service that that uses the Stanford NLP java library to parse and manipulate input text and output a list of sentences containing original text, zombie text, and some artifacts of the text analysis and transformation.

### Deployment
*/provision* 

Ansible playbooks and roles for site setup and backup/restore. Target environment changed several times so there is some junk in here


