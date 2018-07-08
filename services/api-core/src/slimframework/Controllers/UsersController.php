<?php
namespace SlimFramework\Controllers;

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
        $allUsers = $this->getBlueGoCoreDb()->getAllData(new User());

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

        $this->getBlueGoCoreDb()->save($user);

        return $this->buildJsonAPIResponse(200, [$user]);

    }

}