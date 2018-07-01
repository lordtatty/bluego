#!/bin/bash
set -e
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept-integration-tests
