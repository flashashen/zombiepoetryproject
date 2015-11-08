#!/bin/bash

ansible-playbook -vvv -i ramnode.inventory --extra-vars "username=$(whoami)" --ask-pass setup_user.yml
