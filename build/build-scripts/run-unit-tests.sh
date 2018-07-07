#!/bin/bash
set -e
echo "Running BlueGoCore Unit Tests..."
docker run -v $(pwd)/libs/bluegocore/:/app --rm phpunit/phpunit ./tests