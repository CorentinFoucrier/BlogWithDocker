#!/bin/bash

docker-compose build

docker-compose -f docker-compose.yml up -d

sleep 4;

docker exec blog composer update

docker exec blog php commandes/createSql.php

echo "#-------------------------------------------"
echo "#"
echo "# Check your browser to see if it is running"
echo "#"
echo "#-------------------------------------------"

exit 0