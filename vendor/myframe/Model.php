<?php

namespace vendor\myframe;

class Model
{
    protected $connection;
    public function __construct()
    {
        $this->connection = new Connection;
        $this->connection = $this->connection->getConnection();
    }
}