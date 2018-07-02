<?php

namespace BlueGoCore;

use BlueGoCore\Loaders\LoadersFactory;

class BlueGoCore {

    /**
     * @return \BlueGoCore\Loaders\LoadersFactory
     */
    public function getLoaders() {
        return new LoadersFactory();
    }

}