[![Build Status](https://travis-ci.org/lordtatty/docker-compose-test.svg?branch=master)](https://travis-ci.org/lordtatty/docker-compose-test)

**The Project**

This is the first test of my docker-compose-test template:
 
It's an attempt to create a working VLE using a docker environment.  It should require one command to create a dev environment.

**To start development**

The only pre-requisite is to have docker installed.  Once this is done, run:

``sh ./start-dev.sh``

This will pull all required external containers, build local containers, launch an environment,
and map the local development src directories into those containers to make development easier.

Once everything is launched, it will map two webapp endpoints to localhost:

  - ``http://localhost:8080`` This is a yii app which will serve as the frontend.
  - ``http://localhost:8081`` This is an API intended to be the core of the application.
  
From here you can get devving.  Code changes will immediately impact the code on the containers because the local src is mapped as a volume.

**Other useful scripts**

  - ``sh ./build/start-build.sh`` - this is used primarily by the build server (travis by default).  It will build all containers, install all dependencies, launch a full environment (note: it will not map src into the containers - the code is copied in and needs to stand up on its own), run unit tests, launch a firefox container, then run the browser tests.
  - ``sh ./build/install-deps.sh`` - this will install dependencies for containers.  By default, it runs composer on the yii service.
  - ``sh ./build/update-deps.sh`` - this will update dependencies.  By default, it runs composer update on the yii service.
  - ``sh ./build/run-unit-tests.sh`` - does as it says on the tin.
  - ``sh ./build/run-integration-tests.sh`` - also does as it says on the tin.
  - ``sh ./build/run-browser-tests.sh`` - also does as it says on the tin.  It will launch a firefox container, then run the browser tests against it.  
  - ``sh ./build/run-all-tests.sh`` - runs the unit tests, integration tests, and the browser tests.

**The basic structure**

  - ``./services/`` is where the basic services (microservices?) which make up your app will reside
  - ``./build/`` is where the useful scripts & config files required for a build will live.
  - ``browser-tests`` does what it says on the tin.  Codeception is set up as the default.
    The tests for each individual service will live in its own subfolder under here.

**The build**

The dockerfile for each service lives within the service's own directory - ``./services/<servicename>/Dockerfile``.

The docker-compose yaml files all live within ./build/docker-compose-yml

Helper scripts to trigger the key parts of the build live in ``./build/build-scripts``

One script lives in the root directory - this is ``./start-dev.sh`` and will launch a full development environment ready to start devving.

**You probably won't need this part**

When initially setting up codeception, I ran the following command to initialise.  It is unlikely that this will be needed to re-initialise, but I'd rather not lose the knowledge, as it took me a while
to figure out:
docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept bootstrap
OR: docker-compose -f ./build/docker-compose-yml/docker-compose.run-tests.yml run --rm codecept init acceptance
see: https://codeception.com/docs/12-ParallelExecution#Using-Codeception-Docker-image
and: https://codeception.com/quickstart

docker run --rm --interactive --tty --volume $PWD:/app composer (whatever composer compand and params) 
  - This is really useful for initialising or re-initialising containers.  Or for dump-autoload.
