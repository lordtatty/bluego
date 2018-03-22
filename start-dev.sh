#!/bin/bash
set -e
sh ./build/build-scripts/install-deps.sh
docker-compose -f ./build/docker-compose-yml/docker-compose.yml -p docker-compose-test-network up --build