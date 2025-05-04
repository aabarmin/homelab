#!/bin/sh

# git pull
if [ -z "${CLOUDFLARE_TOKEN}" ]; then
    echo "CLOUDFLARE_TOKEN environment variable not set"
    exit 1
fi

ansible-playbook -i inventory.yml playbook.yml -e "CLOUDFLARE_TOKEN=${CLOUDFLARE_TOKEN}"