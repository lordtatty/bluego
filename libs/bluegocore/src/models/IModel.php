<?php

namespace BlueGoCore\Models;


interface IModel {
    public function getPodName();
    public function getArray();
    public function getRawArray();
    public function loadFromArray(array $array);
    public function getUniqueId();
    public function isChanged();

    /**
     * Ensure data is in a valid state
     * to be stored.
     *
     * @return bool true if valid
     */
    public function validateData();

}