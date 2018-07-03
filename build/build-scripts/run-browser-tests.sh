#!/bin/bash
set -e
echo "Running Browser Tests..."
docker-compose -f ./build/docker-compose-yml/docker-compose.start-firefox.yml up -d --build
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept-browser-tests
docker-compose -f ./build/docker-compose-yml/docker-compose.start-firefox.yml down