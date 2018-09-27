<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 08/07/18
 * Time: 23:15
 */

namespace BlueGoCore\Storage\Types;

use BlueGoCore\Models\IModel;

interface IStorageType {

    function save(IModel $model);
    function getAllData(IModel $model);
    function getDataByUniqueId($uniqueId, IModel $model);

} 