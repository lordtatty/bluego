<?php
namespace JsonApi\Tobscure\Serialisers;

use Tobscure\JsonApi\AbstractSerializer;

class UserSerialiser extends AbstractSerializer {
    protected $type = 'users';

    public function getAttributes( $user, array $fields = null)
    {
        /** @var \BlueGoCore\Models\User $user */
        return $user->getArray();
    }
}