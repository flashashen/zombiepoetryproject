#! /bin/bash

docker inspect --format '{{ .NetworkSettings.IPAddress }}' $(docker ps | grep zombie-web | awk '{ print $1 }')
