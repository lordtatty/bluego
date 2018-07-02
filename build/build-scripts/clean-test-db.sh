#!/bin/bash
set -e
echo "Cleaning test db..."
docker-compose -f ./build/docker-compose-yml/docker-compose.yml -p dockercomposetestnetwork exec mongodb bash -c "mongo test --eval \"printjson(db.dropDatabase())\""
