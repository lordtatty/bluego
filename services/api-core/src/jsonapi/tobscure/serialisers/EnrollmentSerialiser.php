<?php
namespace JsonApi\Tobscure\Serialisers;

use Tobscure\JsonApi\AbstractSerializer;
use BlueGoCore\Models\Course;

class EnrollmentSerialiser extends AbstractSerializer {
    // TODO: Does this type mutate???  CourseUser / UserCourse
    protected $type = 'courses';

    public function getAttributes($course, array $fields = null)
    {
        /** @var Course $user */
        return $course->getArray();
    }

    public function getId($course)
    {
        /** User $user */
        return $course->getUniqueId();
    }
}