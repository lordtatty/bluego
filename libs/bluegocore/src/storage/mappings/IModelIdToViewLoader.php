<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 04/10/18
 * Time: 22:35
 */

namespace BlueGoCore\Storage\Mappings;


use BlueGoCore\Storage\StorageManager;

interface IModelIdToViewLoader {

    public function setStorageManager(StorageManager $storageManager);

    /**
     * @param $uniqueId
     * @return \BlueGoCore\Models\Views\IModelView
     */
    public function getViewFromViewUniqueId($uniqueId);

} 