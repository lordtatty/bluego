#!/bin/bash
set -e
echo "Cleaning test db..."
docker-compose -f ./build/docker-compose-yml/docker-compose.yml -p dockercomposetestnetwork exec mongodb bash -c "mongo test --eval \"printjson(db.dropDatabase())\""
docker-compose -f ./build/docker-compose-yml/docker-compose.yml -p dockercomposetestnetwork exec mongodb bash -c "mongo test --eval \"var dbs = db.getMongo().getDBNames(); for(var i in dbs){if(dbs[i].match(/BlueGoTest_*/)){db = db.getMongo().getDB(dbs[i]); db.dropDatabase();}}\""