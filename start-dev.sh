#!/bin/bash
sh ./scripts/install-deps.sh
docker-compose -f ./docker-compose-yml/docker-compose.yml up --build