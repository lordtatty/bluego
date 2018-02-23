#!/bin/bash
docker-compose -f ./docker-compose-yml/docker-compose.install-deps.yml up --build
docker-compose -f ./docker-compose-yml/docker-compose.yml up --build