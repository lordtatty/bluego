#!/bin/bash
set -e
sh ./build/build-scripts/install-deps.sh
docker-compose -f ./build/docker-compose-yml/docker-compose.yml -p dockercomposetestnetwork up -d --build
sleep 10 # Dirty hack to ensure mongodb is up and running before starting the tests.  I wonder if I can poll it?
sh ./build/build-scripts/run-all-tests.sh