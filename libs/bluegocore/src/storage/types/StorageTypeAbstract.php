<?php

namespace BlueGoCore\Storage\Types;

use BlueGoCore\Models\IModel;

abstract class StorageTypeAbstract {

    abstract function save(IModel $model);
    abstract function getAllData(IModel $model);

} 