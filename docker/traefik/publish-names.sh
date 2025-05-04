#!/bin/bash

/usr/bin/avahi-publish -a -R portainer.raspberrypi.local 192.168.88.65 &
/usr/bin/avahi-publish -a -R glances.raspberrypi.local 192.168.88.65 &