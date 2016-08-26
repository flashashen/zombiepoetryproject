import cmd
import os
import json
import re

import yaml

with open("config.yml", 'r') as ymlfile:
    cfg = yaml.load(ymlfile)

for section in cfg:
    print(section)
print(cfg['mysql'])
print(cfg   ['other'])



def getPlaybookModel(filename):
    with open(filename) as file:
        return yaml.load(file)

import glob
playbooks = map(getPlaybookModel, glob.glob("*.yml"));
yaml.dump(playbooks[0])

class HelloWorld(cmd.Cmd):
    """Simple command processor example."""


    APPS = [ 'disputeforms', 'prepaid' ]
    ENVS = [ 'dev', 'prod']

    last_output = ''
    app = '<unknown>'
    command = []



    def do_deploy(self, line):
        # print "deploy called on {0}".format(line)
        jsonParam = json.JSONEncoder().encode({"app": line.split(" ")[0] })
        shellCmd = "ansible-playbook -i ./readydebit.inventory deploy_webapp.playbook --extra-vars '{0}' --limit dev".format(jsonParam)
        output = os.popen(shellCmd).read()
        print(output)
        self.last_output = output
        #with open('.extravars', 'w') as f:
        #    json.dump({"app": line.split(" ")[0] }, f, ensure_ascii=False)
        # print type(jsonParam)
        # shellCmd = "ansible-playbook -i ./readydebit.inventory deploy_webapp.playbook --extra-vars '{0}' --limit dev".format(jsonParam)
        # output = os.popen(shellCmd).read()
        # print output
        # self.last_output = output


    def complete_deploy(self, text, line, begidx, endidx):
        return self.completeFromArrays(line, [self.APPS,self.ENVS])





    def completeFromArrays(self, line, argLists):

        lineSegments = line.split()
        numArgsInput = len(lineSegments)-1;
        endsWithWhitespace = line[-1].isspace()


        # If the input ends in whitespace, the the next completion wil be
        # the whole of the next list in the sequence
        if endsWithWhitespace:
            if numArgsInput >= len(argLists):
                return []
            return argLists[numArgsInput][:]


        # The input cursor is still at the end of the command. Wait for an
        # initial whitespace before returning any completions. Also test
        # for extra arguments
        if numArgsInput == 0 or numArgsInput > len(argLists):
            return []


        # Return any matching values from the relevant list
        return [ f
                for f in argLists[numArgsInput-1]
                if f.startswith(lineSegments[-1])
                ]

	
 
    def do_list(self, line):
        print ('\n'.join(self.APPS))
   
    def help_list(self):
        print ("List known applications. No arguments")

    def complete_list(self, text, line, begidx, endidx):
        if not text:
            completions = self.APPS[:]
        else:
            completions = [ f
                            for f in self.APPS
                            if f.startswith(text)
                            ]
        return completions


 
    def do_EOF(self, line):
        return True

if __name__ == '__main__':
    HelloWorld().cmdloop()
