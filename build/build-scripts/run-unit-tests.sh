#!/bin/bash
set -e
docker exec -it dockercomposetestnetwork_api-core_1 bash -c "vendor/bin/phpunit"