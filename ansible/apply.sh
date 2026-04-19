#!/bin/sh

ansible-playbook -i inventory.yml playbook.yml -K --ask-vault-pass