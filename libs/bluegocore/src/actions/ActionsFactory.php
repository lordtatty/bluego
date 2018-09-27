<?php

namespace BlueGoCore\Actions;

use BlueGoCore\Models\Views\CourseUserView;
use BlueGoCore\Models\Views\UserCourseView;
use BlueGoCore\Storage\StorageManager;

class ActionsFactory {

    /** @var StorageManager */
    protected $storageManager;

    /**
     * Constructor
     *
     * @param StorageManager $storageManager
     */
    public function __construct(StorageManager $storageManager){
        $this->storageManager = $storageManager;
    }

    /**
     * Get an action to enroll a user on a course
     * @return EnrollUserToCourse
     */
    public function getEnrollUserToCourseAction(){
        return new EnrollUserToCourse(
            $this->storageManager,
            new UserCourseView(),
            new CourseUserView()
        );
    }

} 