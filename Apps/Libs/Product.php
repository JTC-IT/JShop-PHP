<?php
require_once 'DBConnection.php';

/**
 * Class get/set Products from database
 *
 * @author trung chinh
 */
class Product
{
    public function getProducts($start, $limit){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Id, Name, Brand, Stocks, Price, Date_Updated from product where Is_Deleted = 0 LIMIT $start, $limit";
        return $db->query_select($sql);
    }

    public function getProductsByPage($categoryId, $key, $start, $limit){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from product where Is_Deleted = 0";
        if($categoryId > 0)
            $sql = $sql." and CategoryId = $categoryId";
        else if($key != null)
            $sql = $sql." and Name LIKE '%$key%'";
        $sql = $sql." LIMIT $start, $limit";
        return $db->query_select($sql);
    }

    public function getProduct($id){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from product where Id = :id";
        $param = [":id" => $id];
        return $db->query_select($sql,$param)[0];
    }

    public function total_records($param = []){
        $db = new  DBConnection('pmmanguonmo');
        $sql = 'select count(Id) as total from product where Is_Deleted = 0';
        if(!is_array($param) || count($param) < 1)
            return $db->query_select($sql)[0]['total'];
        if(isset($param['categoryId']) && $param['categoryId'] > 0)
            $sql = $sql.' and CategoryId = :categoryId';
        else if(isset($param['key']))
            $sql = $sql." and Name LIKE '%:key%'";
        return $db->query_select($sql,$param)['total'];
    }

    //Add product
    public function addProduct($p){
        if(is_array($p)){
            $db = new  DBConnection('pmmanguonmo');
            $sql = "insert into product(Name, Description, Brand, Model_Year, Stocks, Price, Unit, CategoryId) values (:name, :description, :brand, :model_Year, :stocks, :price, :unit, :categoryId)";
            return $db->query_insert($sql,$p);
        }
        return false;
    }

    //Add product
    public function updateProduct($p){
        if(is_array($p)){
            $db = new  DBConnection('pmmanguonmo');
            $sql = "update product set Name = :name, Description = :description, Brand = :brand, Model_Year = :model_Year, Stocks = :stocks, Price = :price, Unit = :unit, CategoryId = :categoryId, Date_Updated = :cur_date where Id = :id";
            return $db->query_update($sql,$p);
        }
        return false;
    }

    //Add product
    public function deleteProduct($id){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "update product set Is_Deleted = 1 where Id = $id";
        return $db->query_update($sql);
    }
}