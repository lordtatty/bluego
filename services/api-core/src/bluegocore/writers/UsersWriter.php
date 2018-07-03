<?php

namespace BlueGoCore\Writers;

use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Models\User;

class UsersWriter {

    /** @var \BlueGoCore\Databases\DatabaseFactory */
    protected $databaseFactory;

    public function __construct(DatabaseFactory $factory){
        $this->databaseFactory = $factory;
    }

    /**
     * @param User $user
     * @throws \Exception
     */
    function saveToDb(User $user) {
        $data = $user->getArray();
        $this->databaseFactory->getMongoDatabase()->insertData($data);
    }

} 