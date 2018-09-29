<?php

namespace BlueGoCore\Storage;


use BlueGoCore\Exceptions\StorageConfigException;
use BlueGoCore\Models\IModel;
use BlueGoCore\Models\IModelConcrete;
use BlueGoCore\Models\Views\CourseUserView;
use BlueGoCore\Models\Views\IModelView;
use BlueGoCore\Models\Views\UserCourseView;
use BlueGoCore\Storage\Mappings\ViewUpdateMapping;
use BlueGoCore\Storage\Types\IPersistableStorageType;
use PHPUnit\Framework\Exception;

/**
 * The StorageManager will keep track of all models loaded
 * from the databaase, cache them, and ultimately save
 * the models back to the database if they have changed.
 *
 * It will also make sure views are updated when necessary
 *
 * Class StorageManager
 * @package BlueGoCore\Storage
 */
class StorageManager {

    /** @var array[IPersistableStorageType] $persistedStorage */
    protected $persistedStorage = [];
    /** @var array[IModel] $models */
    protected $concreteModels = [];
    /** @var array[IModel] $models */
    protected $viewModels = [];

    /**
     * Add a persistable storage type from which
     * data will be loaded and saved
     *
     * @param IPersistableStorageType $storageType
     */
    public function addPersistedStorage(IPersistableStorageType $storageType){
        $this->persistedStorage[] = $storageType;
    }

    /**
     * Add a model to be tracked by the StorageManager.
     *
     * These will be cached and saved when the save
     * method is called.
     *
     * @param IModel $model
     * @return $this
     */
    public function addModel(IModel $model){
        if($model instanceof IModelConcrete) {
            $this->concreteModels[] = $model;
        }
        elseif($model instanceof IModelView) {
            $this->viewModels[] = $model;
        }

        return $this;
    }

    /**
     * Save all loaded models which have changed
     *
     * @throws StorageConfigException
     */
    public function save(){
        $this->errorIfNoStorageManager();
        foreach($this->concreteModels as $model) {
            /** @var IModelConcrete $model*/
            if($model->isChanged()) {
                foreach ($this->persistedStorage as $persistedStorage) {
                    /** @var IPersistableStorageType $persistedStorage */
                    $persistedStorage->save($model);
                    $this->updateViewsForChangedModel($model);
                }
            }
        }
        foreach($this->viewModels as $model) {
            /** @var IModelConcrete $model*/
            if($model->isChanged()) {
                foreach ($this->persistedStorage as $persistedStorage) {
                    /** @var IPersistableStorageType $persistedStorage */
                    $persistedStorage->save($model);
                }
            }
        }
        $this->concreteModels = [];
    }

    protected function updateViewsForChangedModel(IModelConcrete $model){
        /** @var ViewUpdateMapping $mapping */
        $mapping = $this->getDataByUniqueId($model->getUniqueId(), new ViewUpdateMapping());
        if(!empty($mapping)){
            foreach($mapping->getViewUniqueIds() as $uniqueId){
                $uniqueIdParts = explode(':', $uniqueId, 2);
                $viewModel = $this->getModelTypeFromModelString($uniqueIdParts[0]);
                /** @var IModelView $view */
                $view = $this->getDataByUniqueId($uniqueIdParts[1], $viewModel);
                $view->updateInstancesOfModel($model);
            }
        }
    }

    /**
     * @param $modelString
     * @return IModel
     */
    protected function getModelTypeFromModelString($modelString){
        switch($modelString){
            case 'view_user_course':
                return new UserCourseView();
                break;
            case 'view_course_users':
                return new CourseUserView();
                break;
            default:
                throw new Exception('view type not recognised');
        }
    }

    /**
     * Get all data for a particular model
     *
     * @param IModel $model
     * @return array
     * @throws StorageConfigException
     */
    public function getAllData(IModel $model){
        $this->errorIfNoStorageManager();
        foreach ($this->persistedStorage as $persistedStorage) {
            /** @var IPersistableStorageType $persistedStorage */
            $result = $persistedStorage->getAllData($model);
            if(!empty($result)){
                $this->addModel($model);
                return $result;
            }
        }
        return [];
    }

    /**
     * Get a model by it's unique ID
     *
     * Caches results for each model
     *
     * @param $unqiueId
     * @param IModel $model
     * @return IModel|null
     * @throws StorageConfigException
     */
    public function getDataByUniqueId($unqiueId, IModel $model){
        $this->errorIfNoStorageManager();
        foreach ($this->persistedStorage as $persistedStorage) {
            /** @var IPersistableStorageType $persistedStorage */
            $result = $persistedStorage->getDataByUniqueId($unqiueId, $model);
            if(!empty($result)){
                $this->addModel($model);
                return $result;
            }
        }
        return null;
    }

    /**
     * An exception to throw if no persisted storage
     * is loaded
     *
     * @throws StorageConfigException
     */
    protected function errorIfNoStorageManager(){
        if(empty($this->persistedStorage)){
            throw new StorageConfigException('No storage has been added to this storage manager');
        }
    }

} 