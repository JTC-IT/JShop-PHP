<?php
require_once 'DBConnection.php';

/**
 * Class get/set User from database
 *
 * @author trung chinh
 */
class User
{
    public function login($param)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from user where Phone = :phone and Password = :pas and Is_Blocked = 0";
        return $db->query_select($sql,$param);
    }

    public function getUser($id)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from user where Id = $id";
        return $db->query_select($sql)[0];
    }

    public function getUsers($type = 1,$key = '')
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from user";
        if($type == -1)
            $sql .= " where Is_Blocked = 1";
        else $sql .= " where Type = $type and Is_Blocked = 0";
        if($key !== '')
            $sql .= " and (Name like '%$key%' or Phone like '%$key%' or Address like '%$key%')";
        return $db->query_select($sql);
    }

    public function checkPhone($phone, $id = 0)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "select * from user where Phone = $phone";
        if($phone == '')
            return false;
        if($id > 0)
            $sql .= " and Id != $id";
        return count($db->query_select($sql)) === 1;
    }

    public function addUser($param)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "insert into user(Name, Phone, Address, Password, Type) values(:name, :phone, :address, :pass, :type)";
        return $db->query_insert($sql,$param);
    }

    public function updateUser($param)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "update user set Name = :name, Phone = :phone, Address = :address, Password = :pass, Date_Created = current_timestamp(), Type = :type where Id = :id";
        return $db->query_update($sql,$param);
    }

    public function blockUser($id,$b)
    {
        $db = new  DBConnection('pmmanguonmo');
        $sql = "update user set Is_Blocked = $b where Id = $id";
        return $db->query_update($sql);
    }
}