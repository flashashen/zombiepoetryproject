#!/bin/bash

ansible-playbook -vvv -i inventory/main.inventory --extra-vars "username=$(whoami)" -e "ansible_ssh_user=ec2-user" -e 'host_key_checking=False'  --private-key ~/.ssh/default_ec2.pem --ask-vault-pass setup_user.yml --limit $1
