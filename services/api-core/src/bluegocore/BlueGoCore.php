<?php

namespace BlueGoCore;

use BlueGoCore\Databases\DatabaseFactory;
use BlueGoCore\Loaders\LoadersFactory;
use BlueGoCore\Writers\WritersFactory;

class BlueGoCore {

    /**
     * @return \BlueGoCore\Loaders\LoadersFactory
     */
    public function getLoaders() {
        return new LoadersFactory(new DatabaseFactory());
    }

    /**
     * @return \BlueGoCore\Writers\WritersFactory
     */
    public function getWriters() {
        return new WritersFactory(new DatabaseFactory());
    }

}