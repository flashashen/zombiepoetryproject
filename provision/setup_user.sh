#!/bin/bash

ansible-playbook -vvv -i inventory/main.inventory --extra-vars "username=$(whoami)" -e "ansible_ssh_user=ec2-user" --private-key ~/Downloads/zombie_wp_keypair.pem  setup_user.yml --limit $1
