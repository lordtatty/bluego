#!/bin/bash
set -e
docker-compose -f ./build/docker-compose-yml/docker-compose.start-firefox.yml up -d --build
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept
docker-compose -f ./build/docker-compose-yml/docker-compose.start-firefox.yml down