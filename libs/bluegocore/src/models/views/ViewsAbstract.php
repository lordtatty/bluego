<?php

namespace BlueGoCore\Models\Views;


use BlueGoCore\Models\IModel;
use BlueGoCore\Models\ModelAbstract;

abstract class ViewsAbstract extends ModelAbstract implements IModelView {

    protected function setUniqueId($uniqueId){
        $this->modelData['uniqueId'] = $uniqueId;
    }

    protected function addModelToViewArray($key, IModel $model){
        if(!isset($this->modelData[$key])){
            $this->modelData[$key] = [];
        }
        $this->modelData[$key][$model->getUniqueId()] = $model;
    }

    public function getArray(){
        $this->_ensureUniqueId();
        $responseArray = [];
        foreach($this->modelData as $key => $data) {
            if($data instanceof IModel){
                $responseArray[$key] = $data->getArray();
            }
            elseif(is_array($data) && !empty($data)){
                $responseArray[$key] = array_map(function ($element) {
                        if($element instanceof IModel) {
                            return $element->getArray();
                        }
                        return $element;
                    }, $data);
            }
            else{
                $responseArray[$key] = $data;
            }
        }
        unset($responseArray['_id']);
        return $responseArray;
    }

    /**
     * @yeild IModel
     */
    public function iterateAllModels(){
        foreach($this->modelData as $modelArr){
            if(is_array($modelArr)) {
                foreach ($modelArr as $model) {
                    if ($model instanceof IModel) {
                        yield $model;
                    }
                }
            }
            elseif ($modelArr instanceof IModel) {
                yield $modelArr;
            }
        }
    }

}