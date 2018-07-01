#!/bin/bash
set -e
docker exec -it dockercomposetestnetwork_web-yii_1 bash -c "vendor/bin/codecept run unit"