<?php
require_once '../Apps/Libs/Category.php';
$category = new Category();

var_dump($category->getName([':id'=>5])[0]['Name']);