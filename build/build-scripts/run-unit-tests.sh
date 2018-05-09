#!/bin/bash
set -e
docker exec -it docker-compose-test-network_web-reactphp_1 bash -c "vendor/bin/phpunit --bootstrap vendor/autoload.php unittests/CExampleTest.php"