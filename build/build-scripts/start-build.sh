#!/bin/bash
set -e
sh ./build/build-scripts/install-deps.sh
docker-compose -f ./build/docker-compose-yml/docker-compose.yml -p dockercomposetestnetwork up -d --build
sh ./build/build-scripts/run-unit-tests.sh
sh ./build/build-scripts/run-browser-tests.sh
