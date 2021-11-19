<?php
require_once 'DBConnection.php';

/**
 * Class get/set media from database
 *
 * @author trung chinh
 */
class Media
{
    //get image first
    public function getImage($id, $index){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Url from media where ProductId = :id and Indexs = :index";
        $param = [":id" => $id, ':index' => $index];
        return $db->query_select($sql,$param);
    }
    //get all images by productId
    public function getImages($id){
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select Url from media where ProductId = :id and Is_Deleted = :is order by Indexs asc";
        $param = [":id" => $id, ":is" => 0];
        return $db->query_select($sql,$param);
    }

    //add image
    public function addImages($image)
    {
        if(is_array($image) && count($image) == 3){
            $db = new  DBConnection('pmmanguonmo');
            $sql = "insert into media(ProductId, Url, Indexs) values(:productId, :url, :index)";
            return $db->query_update($sql, $image);
        }
        return false;
    }

    //update image
    public function updateImage($image)
    {
        if(is_array($image) && count($image) == 3){
            $db = new  DBConnection('pmmanguonmo');
            $sql = "update media set Url = :url where ProductId = :productId and Indexs = :index";
            return $db->query_update($sql, $image);
        }
        return false;
    }

    //delete image
    public function deleteImage($productId, $index)
    {
        if(is_numeric($productId) && $productId > 0){
            $db = new  DBConnection('pmmanguonmo');
            $sql = "update media set Is_Deleted = 1 where ProductId = :productId and Indexs = :index";
            $params = [":productId" => $productId, ":index"=>$index];
            return $db->query_update($sql, $params);
        }
    }

    //delete image
    public function deleteImages($productId)
    {
        if(is_numeric($productId) && $productId > 0){
            $db = new  DBConnection('pmmanguonmo');
            $sql = "update media set Is_Deleted = 1 where ProductId = :productId";
            $params = [":productId" => $productId];
            return $db->query_update($sql, $params);
        }
    }
}