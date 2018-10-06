<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 04/10/18
 * Time: 22:42
 */

namespace BlueGoCore\Loaders\Views;


use BlueGoCore\Models\Course;
use BlueGoCore\Models\User;
use BlueGoCore\Storage\Mappings\IModelIdToViewLoader;
use BlueGoCore\Storage\StorageManager;

class ViewLoader implements IModelIdToViewLoader{

    /** \BlueGoCore\Storage\StorageManager $storageManager */
    protected $storageManager;

    public function setStorageManager(StorageManager $storageManager){
        $this->storageManager = $storageManager;
    }

    /**
     * @return \BlueGoCore\Storage\StorageManager
     */
    protected function getStorageManager(){
        return $this->storageManager;
    }

    /**
     * @param $uniqueId
     * @throws \Exception
     * @return \BlueGoCore\Models\Views\IModelView
     */
    public function getViewFromViewUniqueId($uniqueId)
    {
        $uniqueIdParts = explode(':', $uniqueId, 2);

        $viewString = $uniqueIdParts[0];
        $modelUniqueId = $uniqueIdParts[1];

        switch($viewString){
            case 'view_user_course':
                $loader = new UserCourseViewLoader($this->storageManager);
                return $loader->getByUniqueId($modelUniqueId);
                break;
            case 'view_course_users':
                $loader = new CourseUserViewLoader($this->storageManager);
                return $loader->getByUniqueId($modelUniqueId);
                break;
            default:
                throw new \Exception('View type not recognised');
        }
    }

}