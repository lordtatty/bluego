<?php

namespace BlueGoCore;

use BlueGoCore\Loaders\LoadersFactory;
use BlueGoCore\Writers\WritersFactory;

class BlueGoCore {

    /**
     * @return \BlueGoCore\Loaders\LoadersFactory
     */
    public function getLoaders() {
        return new LoadersFactory();
    }

    /**
     * @return \BlueGoCore\Writers\WritersFactory
     */
    public function getWriters() {
        return new WritersFactory();
    }

}