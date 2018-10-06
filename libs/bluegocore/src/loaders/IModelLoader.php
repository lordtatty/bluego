<?php

namespace BlueGoCore\Loaders;


interface IModelLoader {

    /**
     * Return the model which matches the passed unique ID
     * or return null if not found
     *
     * @param $id
     * @return \BlueGoCore\Models\IModel|null
     */
    public function getByUniqueId($id);

    /**
     * Create a new model for this loader type
     * And add it to the storage manager
     *
     * @return \BlueGoCore\Models\IModel
     */
    public function createNew();
} 