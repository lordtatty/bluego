#!/bin/bash
set -e
sh ./build/build-scripts/run-unit-tests.sh
sh ./build/build-scripts/run-browser-tests.sh