#!/bin/bash

ansible-playbook -vvv -i main.inventory --ask-vault-pass  backup.yml
#ansible-playbook -vvv -i ramnode_test.inventory backup.yml
