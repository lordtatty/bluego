<?php
/**
 * Created by PhpStorm.
 * User: tatty
 * Date: 09/07/18
 * Time: 01:02
 */

namespace BlueGoCore\Storage\Mappings;

use BlueGoCore\Models\IModel;
use BlueGoCore\Models\ModelAbstract;
use BlueGoCore\Models\Views\IModelView;

class ViewUpdateMapping extends ModelAbstract {

    public function getPodName()
    {
        return 'storage_manager_view_mappings';
    }

    /**
     * Set the User's Forename
     *
     * @param IModelView $model
     */
    public function addView(IModelView $model) {
        $key = $model->getPodName() . ":" . $model->getUniqueId();
        $this->_addToModelPropetyArray('views', $key, [$model->getPodName(), $model->getUniqueId()], 'array');
    }

    public function getViewUniqueIds(){
        return $this->_getModelProperty('views');
    }

    public function setModel(IModel $model){
        $this->_setModelProperty('uniqueId', $model->getUniqueId(), 'string');
    }

    /**
     * Validate the data in the model is
     * safe to store
     *
     * @return bool
     */
    public function validateData(){
        return true;
    }
}