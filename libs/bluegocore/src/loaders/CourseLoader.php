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
     * @param $id
     * @return \BlueGoCore\Models\Course|null
     */
    public function getByUniqueId($id){
        return $this->getStorageManager()->getDataByUniqueId($id, $this->getModel());
    }

    /**
     * @return Course
     */
    public function createNew(){
        $course = $this->getModel();
        $this->getStorageManager()->addModel($course);
        return $course;
    }

    /**
     * @return Course
     */
    protected function getModel(){
        return new Course();
    }


} 