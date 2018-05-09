#!/bin/bash
set -e
docker exec -it dockercomposetestnetwork_web-reactphp_1 bash -c "vendor/bin/phpunit --bootstrap vendor/autoload.php unittests/CExampleTest.php"