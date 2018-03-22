#!/bin/bash
set -e
docker-compose -f ./build/docker-compose-yml/docker-compose.install-deps.yml up --build
