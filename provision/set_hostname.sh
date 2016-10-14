#!/bin/bash

ansible-playbook -vvv -i inventory/main.inventory zombie_sethostname.yml --ask-vault-pass --limit $1
