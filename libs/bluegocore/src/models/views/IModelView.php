<?php

namespace BlueGoCore\Models\Views;


use BlueGoCore\Models\IModel;

interface IModelView extends IModel{
    public function iterateAllModels();

} 