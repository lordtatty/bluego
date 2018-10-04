<?php

namespace BlueGoCore\Loaders\Views;


use BlueGoCore\Models\Course;
use BlueGoCore\Models\IModelConcrete;
use BlueGoCore\Models\Views\CourseUserView;

class CourseUserViewLoader extends ViewLoaderAbstract {

    /**
     * @param Course $course
     * @return \BlueGoCore\Models\Views\CourseUserView
     */
    public function loadFromCourse(Course $course){
        return $this->loadFromStorageManager($course);
    }

    /**
     * @return \BlueGoCore\Models\Views\CourseUserView
     */
    protected function getViewModel(IModelConcrete $course){
        return new CourseUserView($course);
    }

} 