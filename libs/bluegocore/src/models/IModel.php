<?php

namespace BlueGoCore\Models;


interface IModel {
    public function getPodName();
    public function getArray();
    public function getRawArray();
    public function loadFromArray(array $array);
    public function getUniqueId();
    public function isChanged();
}