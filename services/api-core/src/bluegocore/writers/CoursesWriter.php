<?php

namespace BlueGoCore\Writers;

class CoursesWriter extends WriterAbstract{

    /**
     * Get the pod name for this model.
     *
     * In MongoDb this will be the collection name
     * In MySQL this will be the table name
     *
     * @return string the pod name
     */
    protected function _getPodName()
    {
        return 'courses';
    }


}