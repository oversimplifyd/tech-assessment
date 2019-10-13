<?php

namespace Language\Adapters;

class LogAdapter {

    public function log($data)
    {
        echo $data;
    }

    public function addFile($location, $file)
    {
        return file_put_contents($location, $file);
    }
}
