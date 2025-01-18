#!/bin/sh

git pull
ansible-playbook -i inventory.yml playbook.yml