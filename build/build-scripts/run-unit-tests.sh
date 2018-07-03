#!/bin/bash
set -e
echo "Running Unit Tests..."
docker exec -it dockercomposetestnetwork_api-core_1 bash -c "vendor/bin/phpunit"