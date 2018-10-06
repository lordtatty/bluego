<?php
namespace JsonApi\Tobscure\Serialisers;

use Tobscure\JsonApi\AbstractSerializer;
use \BlueGoCore\Models\User;

class UserSerialiser extends AbstractSerializer {
    protected $type = 'users';

    public function getAttributes($user, array $fields = null)
    {
        /** @var User $user */
        return $user->getArray();
    }

    public function getId($user)
    {
        /** User $user */
        return $user->getUniqueId();
    }
}