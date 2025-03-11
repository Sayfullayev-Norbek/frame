<?php

namespace vendor\myframe;

use vendor\myframe\Views;
class Controller
{
    protected Views $view;

    public function __construct()
    {
        $this->view = new Views();
    }
}