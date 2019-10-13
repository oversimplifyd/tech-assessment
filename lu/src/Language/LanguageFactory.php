<?php

namespace Language\Language;

use Language\Adapters\ConfigAdapter;

class LanguageFactory {

    private $config;

    public function __construct(ConfigAdapter $config)
    {
        $this->config = $config;
    }

    public function makeApplet()
    {
        return new AppletLanguage($this->config);
    }

    public function makeNormal()
    {
        return new NormalLanguage($this->config);
    }
}
