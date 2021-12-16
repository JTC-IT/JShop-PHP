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
        $sql = "select Id, Name from category where ParentId is NULL and Is_Deleted = 0";
        return $db->query_select($sql);
    }

    public function getCategoryLast(){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "SELECT Id, Name FROM category AS c WHERE c.Is_Deleted = 0 AND NOT EXISTS (SELECT * FROM category WHERE ParentId = c.Id)";
        return $db->query_select($sql);
    }

    public function getAllCategory($name = '')
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from category where Is_Deleted = 0";
        if($name != '')
            $sql .= " and Name like '%$name%'";
        return $db->query_select($sql);
    }

    public function getCategoryChild($parentId)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Id, Name from category where ParentId = :parentId and Is_Deleted = :kt";
        $param = [":parentId" => $parentId, ':kt'=>0];
        return $db->query_select($sql,$param);
    }

    public function getName($param){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Name from category";
        if(isset($param[':id']))
            $sql .= " where Id = :id";
        else
            $sql .= " where Name = :name";
        $sql .= " and Is_Deleted = :kt";
        $param[':kt'] = 0;
        return $db->query_select($sql,$param);
    }

    public function addCategory($param){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "insert into category(Name, ParentId) values(:name, :parentId)";
        return $db->query_insert($sql,$param);
    }

    public function updateCategory($param){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "update category set Name = :name, ParentId = :parentId, Date_Updated = current_timestamp() where Id = :id";
        return $db->query_update($sql,$param);
    }

    public function deleteCategory($id){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "update category set Is_Deleted = 1 where Id = $id";
        return $db->query_update($sql);
    }
}