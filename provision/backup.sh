#!/bin/bash

ansible-playbook -vvv -i main.inventory backup.yml
#ansible-playbook -vvv -i ramnode_test.inventory backup.yml
