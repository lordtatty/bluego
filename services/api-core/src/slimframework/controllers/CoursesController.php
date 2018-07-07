<?php
namespace SlimFramework\Controllers;

use JsonApi\Tobscure\Serialisers\CoursesSerialiser;
use Slim\Http\Request;
use Slim\Http\Response;

class CoursesController extends ControllerAbstract {


    protected function _getJsonApiSerialiser()
    {
        return new CoursesSerialiser();
    }

//    /**
//     * GetUsers route
//     *
//     * This gets all users
//     *
//     * @param Request $request
//     * @param Response $response
//     * @param array $args
//     * @return Response
//     */
//    protected function getUsers(Request $request, Response $response, array $args) {
//        $allUsers = $this->getBlueGoCore($request)
//            ->getReaders()
//            ->getUsersReader()
//            ->getAllUsers();
//
//        return $this->buildJsonAPIResponse(200, $allUsers);
//    }

    /**
     * Add Course route
     *
     * Adds a single user
     *   - name
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    protected function addCourse(Request $request, Response $response, array $args) {
        $course = new \BlueGoCore\Models\Course();
        $course->setTitle($request->getParam('title'));
        $course->setCourseCode($request->getParam('course_code'));

        $writer = $this->getBlueGoCore($request)
            ->getWriters()
            ->getCoursesWriter();
        $writer->saveToDb($course);

        return $this->buildJsonAPIResponse(200, [$course]);

    }

}