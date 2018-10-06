<?php

namespace BlueGoCore\Loaders\Views;


use BlueGoCore\Models\Views\CourseUserView;

class CourseUserViewLoader extends ViewLoaderAbstract {

    /**
     * @param $id
     * @return \BlueGoCore\Models\Views\CourseUserView|null
     */
    public function getByUniqueId($id){
        return $this->getStorageManager()->getDataByUniqueId($id, $this->getModel());
    }

    /**
     * @return CourseUserView
     */
    public function createNew(){
        $user = $this->getModel();
        $this->getStorageManager()->addModel($user);
        return $user;
    }

    /**
     * @return \BlueGoCore\Models\Views\CourseUserView
     */
    protected function getModel(){
        return new CourseUserView();
    }

} 