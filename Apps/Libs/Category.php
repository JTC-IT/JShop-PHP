<?php
require_once 'DBConnection.php';

/**
 * Class get/set Category from database
 *
 * @author trung chinh
 */
class Category
{
    public function getCategory()
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Id, Name from category where ParentId is NULL";
        return $db->query_select($sql);
    }

    public function getAllCategory()
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Id, Name from category";
        return $db->query_select($sql);
    }

    public function getCategoryChild($parentId)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Id, Name from category where ParentId = :parentId";
        $param = [":parentId" => $parentId];
        return $db->query_select($sql,$param);
    }
}