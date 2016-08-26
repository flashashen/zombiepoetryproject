#!/bin/bash

ansible-playbook -vvv -i inventory/main.inventory zombie_sethostname.yml --limit $1
