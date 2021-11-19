<?php
/**
 * Connect database and query data
 *
 * @author trung chinh
 */
class DBConnection {
    private $connect;

    public function __construct($database) {
        $host = 'localhost';
        $username = 'root';
        $password = '';

        $this->connect($host, $database, $username, $password);
    }

    public function __destruct()
    {
        $this->connect = null;
    }

    public function closeDb()
    {
        $this->connect = null;
    }

    public function connect($host, $database, $username, $password) {
        if($this->connect === null){
            try {
                $this->connect = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
                die();
            }
        }
    }

    public function query_select($sql, $params = []) {
        $q = $this->connect->prepare($sql);
        $check = false;

        if(is_array($params) && $params)
            $check = $q->execute($params);
        else $check = $q->execute();
        if($check) return $q->fetchAll(PDO::FETCH_ASSOC);
        return null;
    }

    public function query_insert($sql, $params = []) {
        $q = $this->connect->prepare($sql);
        $result = false;
        if(is_array($params) && $params)
            $result = $q->execute($params);
        else $result = $q->execute();
        if($result) return $this->connect->lastInsertId();
        return false;
    }

    public function query_update($sql, $params = []) {
        $q = $this->connect->prepare($sql);

        if(is_array($params) && $params){
            return $q->execute($params);
        }else return $q->execute();
    }
}