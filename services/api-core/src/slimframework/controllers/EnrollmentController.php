<?php
namespace SlimFramework\Controllers;

use BlueGoCore\Actions\EnrollUserToCourse;
use BlueGoCore\Loaders\CourseLoader;
use BlueGoCore\Loaders\UserLoader;
use BlueGoCore\Loaders\Views\ViewLoaderFactory;
use JsonApi\Tobscure\Serialisers\EnrollmentSerialiser;
use Slim\Http\Request;
use Slim\Http\Response;

class EnrollmentController extends ControllerAbstract {


    protected function _getJsonApiSerialiser()
    {
        return new EnrollmentSerialiser();
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
    protected function addEnrollment(Request $request, Response $response, array $args) {
        $courseLoader = new CourseLoader($this->getStorageManager());
        $course = $courseLoader->getByUniqueId($request->getParam('courseUniqueId'));
        if($course == null){
            return $this->notFound();
        }

        $userLoader = new UserLoader($this->getStorageManager());
        $user = $userLoader->getByUniqueId($request->getParam('userUniqueId'));
        if($user == null){
            return $this->notFound();
        }

        $action = new EnrollUserToCourse(
            new ViewLoaderFactory($this->getStorageManager())
        );

        $action->setUser($user);
        $action->setCourse($course);
        $action->perform();
        return $this->success([]);
    }

}