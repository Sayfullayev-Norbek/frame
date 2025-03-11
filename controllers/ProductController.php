<?php

namespace controllers;

use vendor\myframe\Connection;
use vendor\myframe\Controller;

class ProductController extends Controller
{
    public function list()
    {
        $sql = "SELECT * FROM `product`";
        $connection = new Connection;
        $connection = $connection->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $this->view->render('product/list', [
            'productList' => $result
        ]);
    }

    public function add()
    {
        $this->view->render('product/add');
    }
}