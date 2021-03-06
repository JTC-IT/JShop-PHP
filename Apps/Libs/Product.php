<?php
require_once 'DBConnection.php';

/**
 * Class get/set Products from database
 *
 * @author trung chinh
 */
class Product
{
    public function getProducts($param = []){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from product where Is_Deleted = 0";
        if(isset($param['categoryId']) && $param['categoryId'] > 0)
            $sql = $sql." and CategoryId = ".$param['categoryId'];
        if(isset($param['key']) && $param['key'] != null && $param['key'] != '')
            $sql = $sql." and Name LIKE '%".$param['key']."%'";
        if(!isset($param['start']))
            $param['start'] = 0;
        if(!isset($param['limit']))
            $param['limit'] = 9;
        $sql = $sql." LIMIT ".$param['start'].", ".$param['limit'];
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
            $sql = $sql." and CategoryId = ".$param['categoryId'];
        else if(isset($param['key']) && $param['key'] != '')
            $sql = $sql." and Name LIKE '%".$param['key']."%'";
        return $db->query_select($sql)[0]['total'];
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