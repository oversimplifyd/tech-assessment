<?php

namespace Language\Language;

interface Language {

    public function get($id);

    public function getFile($id, $language);
}
