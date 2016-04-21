#!/bin/bash

ansible-playbook -vvv -i ramnode_test.inventory --extra-vars "username=$(whoami)" --ask-pass setup_user.yml
