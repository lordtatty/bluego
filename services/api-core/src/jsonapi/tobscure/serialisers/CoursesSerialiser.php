<?php
namespace JsonApi\Tobscure\Serialisers;

use Tobscure\JsonApi\AbstractSerializer;
use BlueGoCore\Models\Course;

class CoursesSerialiser extends AbstractSerializer {
    protected $type = 'courses';

    public function getAttributes( $course, array $fields = null)
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