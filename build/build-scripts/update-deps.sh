#!/bin/bash
set -e
docker-compose -f ./build/docker-compose-yml/docker-compose.update-deps.yml up --build
