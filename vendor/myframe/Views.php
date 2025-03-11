<?php

namespace vendor\myframe;

class  Views
{
    public function render(string $viewFile, array $data = null): void
    {
        if(!is_null($data)){
            extract($data);
        }

        include 'views/layout/main.php';
        include 'views/' . $viewFile . '.php';
        include 'views/layout/footer.php';
    }
}