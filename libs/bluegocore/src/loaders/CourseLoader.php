<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Models\Course;

class CourseLoader extends ModelConcreteLoaderAbstract {

    /**
     * @return array[Course]
     */
    public function getAll(){
        return $this->getStorageManager()->getAllData(new Course());
    }

} 