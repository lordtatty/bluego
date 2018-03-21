#!/bin/bash
docker-compose -f ./docker-compose-yml/docker-compose.start-firefox.yml up -d gi--build
docker-compose -f ./docker-compose-yml/docker-compose.run-tests.yml up --build