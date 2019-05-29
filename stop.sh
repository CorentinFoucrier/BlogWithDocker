#!/bin/bash

docker-compose stop

sleep 3;

docker-compose rm -f

echo "Container stopped !"

exit 0