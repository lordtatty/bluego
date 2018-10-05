<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Models\Course;

class CourseLoader extends ModelConcreteLoaderAbstract {

    /**
     * @return array[Course]
     */
    public function getAll(){
        return $this->getStorageManager()->getAllData($this->getModel());
    }

    /**
     * @return Course
     */
    public function createNew(){
        $user = $this->getModel();
        $this->getStorageManager()->addModel($user);
        return $user;
    }

    /**
     * @return Course
     */
    protected function getModel(){
        return new Course();
    }


} 