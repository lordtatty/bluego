<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 04/10/18
 * Time: 22:42
 */

namespace BlueGoCore\Loaders\Views;


use BlueGoCore\Storage\StorageManager;

class ViewLoaderFactory {

    /** \BlueGoCore\Storage\StorageManager $storageManager */
    protected $storageManager;

    public function __construct(StorageManager $storageManager){
        $this->storageManager = $storageManager;
    }

    /**
     * @return CourseUserViewLoader
     */
    public function getCourseUserViewLoader() {
        return new CourseUserViewLoader($this->storageManager);
    }

    /**
     * @return UserCourseViewLoader
     */
    public function getUserCourseViewLoader() {
        return new UserCourseViewLoader($this->storageManager);
    }
}