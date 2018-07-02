<?php

namespace BlueGoCore\Loaders;

class LoadersFactory {

    /**
     * @return \BlueGoCore\Loaders\UsersLoader
     */
    public function getUsersLoader(){
        return new \BlueGoCore\Loaders\UsersLoader();
    }
}