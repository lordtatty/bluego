<?php
namespace SlimFramework\Controllers;

use BlueGoCore\Loaders\CourseLoader;
use JsonApi\Tobscure\Serialisers\CoursesSerialiser;
use Slim\Http\Request;
use Slim\Http\Response;

class CoursesController extends ControllerAbstract {


    protected function _getJsonApiSerialiser()
    {
        return new CoursesSerialiser();
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
    protected function getCourses(Request $request, Response $response, array $args) {
        $courseLoader = new CourseLoader($this->getStorageManager());
        $allCourses = $courseLoader->getAll();

        return $this->success($allCourses);
    }

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
        $courseLoader = new CourseLoader($this->getStorageManager());
        $course = $courseLoader->createNew();
        $course->setTitle($request->getParam('title'));
        $course->setCourseCode($request->getParam('course_code'));

        $this->getStorageManager()->save();

        return $this->success([$course]);
    }

}