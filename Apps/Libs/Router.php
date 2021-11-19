<?php

class Router
{
    const HOME_PAGE = "Home";
    private $sourcePath;

    public function __construct($sourcePath = "")
    {
        if($sourcePath)
            $this->sourcePath = $sourcePath;
    }

    public function getGET($param)
    {
        return isset($_GET[$param]) ? $_GET[$param] : NULL;
    }

    public function getPOST($param)
    {
        return isset($_POST[$param]) ? $_POST[$param] : NULL;
    }

    public function router($param)
    {
        $page = $this->getGET($param);
        if(!$page){
            $page = self::HOME_PAGE;
        }
        $path = $this->sourcePath."/".$page;
        if(file_exists($path)){
            return require_once $path;
        }
        else{
            echo '404 Page Not Found !';
            die();
        }
    }
}