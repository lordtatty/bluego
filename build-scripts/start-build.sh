#!/bin/bash
set -e
sh ./build-scripts/install-deps.sh
docker-compose -f ./docker-compose-yml/docker-compose.yml -p dockerComposeTestNetwork up -d --build
sh ./build-scripts/run-browser-tests.sh