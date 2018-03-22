#!/bin/bash
set -e
sh ./build/build-scripts/install-deps.sh
docker-compose -f ./build/docker-compose-yml/docker-compose.yml -p dockerComposeTestNetwork up -d --build
sh ./build/build-scripts/run-browser-tests.sh
