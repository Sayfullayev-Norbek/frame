<?php

namespace controllers;


use models\Category;
use vendor\myframe\Controller;

class CategoryController extends Controller
{
    public function list(): void
    {
        $category = new Category();
        $result = $category->getCategoryList();

        $this->view->render('category/list', ['list' => $result]);
    }

    public function add()
    {
        $this->view->render('category/add');
    }

    public function update(int $id)
    {
        echo 'Category update: ' . $id;
    }
}