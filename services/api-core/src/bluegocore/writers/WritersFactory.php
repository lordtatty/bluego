<?php

namespace BlueGoCore\Writers;

class WritersFactory {

    /**
     * @return \BlueGoCore\Writers\UsersWriter
     */
    public function getUsersWriter(){
        return new \BlueGoCore\Writers\UsersWriter();
    }
}