#!/bin/bash
set -e
sh ./build/build-scripts/clean-test-db.sh
echo "Running integration Tests..."
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept-integration-tests
