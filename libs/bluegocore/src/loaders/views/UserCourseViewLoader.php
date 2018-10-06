<?php

namespace BlueGoCore\Loaders\Views;

use BlueGoCore\Models\IModelConcrete;
use BlueGoCore\Models\User;
use BlueGoCore\Models\Views\UserCourseView;

class UserCourseViewLoader extends ViewLoaderAbstract {
    /**
     * @param $id
     * @return \BlueGoCore\Models\Views\UserCourseView|null
     */
    public function getByUniqueId($id){
        return $this->getStorageManager()->getDataByUniqueId($id, $this->getModel());
    }

    /**
     * @return UserCourseView
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
        return new UserCourseView();
    }

} 