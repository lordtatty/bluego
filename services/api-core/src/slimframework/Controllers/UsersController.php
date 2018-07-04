<?php
namespace SlimFramework\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class UsersController extends ControllerAbstract {

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
    public function getUsers(Request $request, Response $response, array$args) {
        $allUsers = $this->getBlueGoCore()
            ->getLoaders()
            ->getUsersLoader()
            ->getAllUsers();

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
    public function addUser(Request $request, Response $response, array $args) {
        $user = new \BlueGoCore\Models\User();
        $user->setName($request->getParam('name'));
        $user->setAge($request->getParam('age'));

        $writer = $this->getBlueGoCore()
            ->getWriters()
            ->getUsersWriter();
        $writer->saveToDb($user);

        return $this->buildJsonAPIResponse(200, [$user]);

    }

}