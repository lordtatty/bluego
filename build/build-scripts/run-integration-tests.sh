#!/bin/bash
## Usage: run-integration-test.sh <Optional:TestSuite> <Optional:SpecificTestMethod>
set -e
if [ -n "$1" ]; then SPECIFIC_TEST="run api-core-integration $1"; fi
if [ -n "$2" ]; then SPECIFIC_TEST+=":$2"; fi
sh ./build/build-scripts/clean-test-db.sh
echo "Running integration Tests..."
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept-integration-tests $SPECIFIC_TEST
