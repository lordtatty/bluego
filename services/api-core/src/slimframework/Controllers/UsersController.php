<?php
namespace SlimFramework\Controllers;

use BlueGoCore\Actions\ActionsFactory;
use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
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
    protected function getUsers(Request $request, Response $response, array $args) {
        $allUsers = $this->getStorageManager()->getAllData(new User());

        return $this->buildJsonAPIResponse(200, $allUsers);
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
        $user = new \BlueGoCore\Models\User();
        $user->setForename($request->getParam('forename'));
        $user->setSurname($request->getParam('surname'));

        $this->getStorageManager()
            ->addModel($user)
            ->save();

        ////// Testing - remove ////
        $allCourses = $this->getStorageManager()->getAllData(new Course());

        $actionFactory = new ActionsFactory($this->getStorageManager());
        $action = $actionFactory->getEnrollUserToCourseAction();

        $action->setUser($user);
        foreach ($allCourses as $c) {
            $action->setCourse($c);
            $action->perform();
        }

        $this->getStorageManager()->save();
        ////////////////////////////

        return $this->buildJsonAPIResponse(200, [$user]);

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
        $user = new \BlueGoCore\Models\User();
        $this->getStorageManager()->getDataByUniqueId($args['uniqueId'], $user);

        $user->setForename($request->getParam('forename'));
        $user->setSurname($request->getParam('surname'));

        $this->getStorageManager()->addModel($user)->save();

        return $this->buildJsonAPIResponse(200, [$user]);

    }

}