<?php

namespace BlueGoCore\Models;

use MongoDB\Model\BSONDocument;

interface BsonPopulatable {

    public function setByBson(BSONDocument $bson);
} 