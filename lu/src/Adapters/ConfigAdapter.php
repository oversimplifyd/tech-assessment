<?php

namespace Language\Adapters;

use Language\Config;

class ConfigAdapter {

    public function get($key)
    {
        return Config::get($key);
    }
}
