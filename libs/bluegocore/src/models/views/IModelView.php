<?php

namespace BlueGoCore\Models\Views;


use BlueGoCore\Models\IModel;
use BlueGoCore\Models\IModelConcrete;

interface IModelView extends IModel{
    public function iterateAllModels();
    public function updateInstancesOfModel(IModelConcrete $model);

} 