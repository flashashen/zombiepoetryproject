#!/bin/bash

#ansible-playbook -vvv -i ramnode_test.inventory host_zombie_wp.yml
ansible-playbook -vvv -i inventory/main.inventory --ask-vault-pass host_zombie_wp.yml --limit $1
