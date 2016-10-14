#!/bin/bash

ansible-playbook -vvv -i inventory/main.inventory backup_db.yml --ask-vault-pass --limit=52.39.104.229
#50.112.10.226
