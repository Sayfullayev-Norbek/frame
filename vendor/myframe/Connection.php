<?php

namespace vendor\myframe;

use PDO;

class Connection
{
    private $connection;
    private $dbhost = "localhost";
    private $dbport = 3306;
    private $dbuser  = "root";
    private $dbpassword = '';
    private $dbname = "magazin";

    public function __construct()
    {
        $this->connection = new PDO("mysql:host={$this->dbhost};
    dbname={$this->dbname}", $this->dbuser, $this->dbpassword,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public function getConnection()
    {
        return $this->connection;
    }
}