<?php
namespace SlimFramework\Controllers;

use BlueGoCore\Loaders\CourseLoader;
use BlueGoCore\Loaders\Views\UserCourseViewLoader;
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
    protected function getAll(Request $request, Response $response, array $args) {
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

        return $this->success([$course]);
    }

    /**
     * Get all courses for a single user
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    protected function getByUser(Request $request, Response $response, array $args) {
        $loader = new UserCourseViewLoader($this->getStorageManager());
        $userCourseView = $loader->getByUniqueId($args['uniqueId']);

        $courses = [];

        if($userCourseView !== null){
            foreach($userCourseView->getCourses() as $c){
                $courses[] = $c;
            }
        }


        return $this->success($courses);
    }

}