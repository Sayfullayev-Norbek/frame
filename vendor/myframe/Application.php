<?php

namespace vendor\myframe;

class Application
{
    private ?int $id = null;
    public function run()
    {
        $uri = $_SERVER["REQUEST_URI"];

        $dataUri = explode("/", $uri);

        $classname = ucfirst($dataUri[2]) . "Controller";
        $classname = "controllers\\" . $classname ;

        $functionName = $dataUri[3];

        if (isset($dataUri[4])) {
            $this->id = $dataUri[4];
        }

        $object = new $classname();

        if (is_null($this->id)) {
            $object->{$functionName}();
        }else{
            $object->{$functionName}($this->id);
        }

    }
}