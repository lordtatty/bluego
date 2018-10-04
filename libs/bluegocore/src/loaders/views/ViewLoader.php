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
use BlueGoCore\Storage\Mappings\ModelIdToViewLoader;
use BlueGoCore\Storage\StorageManager;

class ViewLoader implements ModelIdToViewLoader{

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
                $user = $this->getStorageManager()->getDataByUniqueId($modelUniqueId, new User());
                return $loader->loadFromUser($user);
                break;
            case 'view_course_users':
                $loader = new CourseUserViewLoader($this->storageManager);
                $course = $this->getStorageManager()->getDataByUniqueId($modelUniqueId, new Course());
                return $loader->loadFromCourse($course);                break;
            default:
                throw new \Exception('View type not recognised');
        }
    }
}