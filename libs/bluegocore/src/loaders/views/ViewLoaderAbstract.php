<?php

namespace BlueGoCore\Loaders\Views;


use BlueGoCore\Models\IModelConcrete;
use BlueGoCore\Storage\StorageManager;

abstract class ViewLoaderAbstract {

    private $storageManager;

    public function __construct(StorageManager $storageManager){
        $this->storageManager = $storageManager;
    }

    /**
     * @param IModelConcrete $concreteModel
     * @return \BlueGoCore\Models\Views\IModelView
     */
    protected function loadFromStorageManager(IModelConcrete $concreteModel){
        $viewModel = $this->storageManager->getDataByUniqueId($concreteModel->getUniqueId(), $this->getViewModel($concreteModel));
        if($viewModel === null){
            $viewModel = $this->getViewModel($concreteModel);
            $this->storageManager->addModel($viewModel);
        }
        return $viewModel;
    }

    /**
     * @param IModelConcrete $modelKey
     * @return \BlueGoCore\Models\IModel
     */
    abstract protected function getViewModel(IModelConcrete $modelKey);

} 