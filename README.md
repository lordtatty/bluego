Notes: To turn into a proper readme later.

To initialise codeception tests do:
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept bootstrap
OR: docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept init acceptance
see: https://codeception.com/docs/12-ParallelExecution#Using-Codeception-Docker-image
and: https://codeception.com/quickstart