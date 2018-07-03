<?php

namespace BlueGoCore\Loaders;

use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Models\User;

/**
 * Class UsersLoader
 *
 * @package BlueGoCore\Loaders
 */
class UsersLoader{

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }


    /**
     * Returns an array of all known users
     *
     * @return array[\BlueGoCore\Models\User]
     */
    public function getAllUsers() {
        $result = $this->databaseFactory->getMongoDatabase()->getAllData();

        $response = [];
        foreach($result as $r){
            $userObject = new User();
            $userObject->setByBson($r);
            $response[] = $userObject;
        }

        return $response;

    }
}