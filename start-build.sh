#!/bin/bash
set -e
sh ./scripts/install-deps.sh
docker-compose -f ./docker-compose-yml/docker-compose.yml -p dockerComposeTestNetwork up -d --build
sh ./scripts/run-browser-tests.sh
