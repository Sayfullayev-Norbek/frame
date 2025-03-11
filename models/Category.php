<?php

namespace models;

use vendor\myframe\Model;

class Category extends Model
{
    public function getCategoryList(): array
    {
        $sql = "SELECT * FROM `category`";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}