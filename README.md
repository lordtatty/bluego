**The Project**

This project template has two goals:
  - A developer should need to run only a single command to get a working development environment
  - The differences between the live and dev environments should be kept to the bare minimum necessary

**To start development**
The only pre-requisite is to have docker installed.  Once this is done simply run:
``sh ./start-dev.sh``

This will pull all required external containers, build local containers, launch an environment,
and map the local development src directories into those containers to make development easier

**The basic structure**
  - ``./services/`` is where the basic services (microservices?) which make up your app will reside
  - ``./build/`` is where the useful scripts & config files will live which are required
    for a build.
  - ``browser-tests`` does exactly what it says on the tin.  Codeception is set up as the default.
    The tests for each individual service will live in it's own subfolder under here.

When initially setting up codeception I ran the following command to initialise.  It is unlikely
this will be needed to re-initialise, but I'd rather not lose the knowledge, as it took me a while
to figure out:
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept bootstrap
OR: docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept init acceptance
see: https://codeception.com/docs/12-ParallelExecution#Using-Codeception-Docker-image
and: https://codeception.com/quickstart