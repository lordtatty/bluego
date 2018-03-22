#!/bin/bash
set -e
docker-compose -f ./docker-compose-yml/docker-compose.install-deps.yml up --build
