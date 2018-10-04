<?php

namespace BlueGoCore\Loaders\Views;

use BlueGoCore\Models\IModelConcrete;
use BlueGoCore\Models\User;
use BlueGoCore\Models\Views\UserCourseView;

class UserCourseViewLoader extends ViewLoaderAbstract {

    /**
     * @param User $user
     * @return \BlueGoCore\Models\Views\UserCourseView
     */
    public function loadFromUser(User $user){
        return $this->loadFromStorageManager($user);
    }

    /**
     * @return \BlueGoCore\Models\Views\UserCourseView
     */
    protected function getViewModel(IModelConcrete $user){
        return new UserCourseView($user);
    }

} 