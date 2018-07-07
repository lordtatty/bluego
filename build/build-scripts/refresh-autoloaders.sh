#!/bin/bash
set -e
docker run --rm --interactive --tty --volume $(pwd):/app composer dump-autoload --working-dir="./libs/bluegocore"
docker run --rm --interactive --tty --volume $(pwd):/app composer dump-autoload --working-dir="./services/api-core/src"