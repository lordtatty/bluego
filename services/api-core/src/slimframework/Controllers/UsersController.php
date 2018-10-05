<?php
namespace SlimFramework\Controllers;

use BlueGoCore\Actions\EnrollUserToCourse;
use BlueGoCore\Loaders\CourseLoader;
use BlueGoCore\Loaders\UserLoader;
use BlueGoCore\Loaders\Views\ViewLoaderFactory;
use Slim\Http\Request;
use Slim\Http\Response;

class UsersController extends ControllerAbstract {

    protected function _getJsonApiSerialiser()
    {
        return new \JsonApi\Tobscure\Serialisers\UserSerialiser();
    }

    /**
     * GetUsers route
     *
     * This gets all users
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    protected function getAll(Request $request, Response $response, array $args) {
        $userLoader = new UserLoader($this->getStorageManager());
        $allUsers = $userLoader->getAll();

        return $this->success($allUsers);
    }

    /**
     * Get a single user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    protected function getById(Request $request, Response $response, array $args) {
        $userLoader = new UserLoader($this->getStorageManager());
        $user = $userLoader->getByUniqueId($args['uniqueId']);

        if(!is_null($user)) {
            return $this->success([$user]);
        }
        else{
            return $this->notFound();
        }
    }

    /**
     * Add User route
     *
     * Adds a single user
     *   - name
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    protected function addUser(Request $request, Response $response, array $args) {
        $userLoader = new UserLoader($this->getStorageManager());
        $user = $userLoader->createNew();
        $user->setForename($request->getParam('forename'));
        $user->setSurname($request->getParam('surname'));

        ////// Testing - remove ////
        $courseLoader = new CourseLoader($this->getStorageManager());
        $allCourses = $courseLoader->getAll();

        $action = new EnrollUserToCourse(
            new ViewLoaderFactory($this->getStorageManager())
        );

        $action->setUser($user);
        foreach ($allCourses as $c) {
            $action->setCourse($c);
            $action->perform();
        }

        ////////////////////////////

        return $this->success([$user]);

    }


    /**
     * Add User route
     *
     * Adds a single user
     *   - name
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    protected function updateUser(Request $request, Response $response, array $args) {
        $userLoader = new UserLoader($this->getStorageManager());
        $user = $userLoader->getByUniqueId($args['uniqueId']);

        if($user === null){
            return $this->notFound();
        }

        $user->setForename($request->getParam('forename'));
        $user->setSurname($request->getParam('surname'));
        
        return $this->success([$user]);

    }

}