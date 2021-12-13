<?php
require_once '../Libs/Media.php';

//create class media
$media = new Media();

if(isset($_GET['Id']) && is_numeric($_GET['Id']) && $_GET['Id'] > 0){
    $media->deleteImage($_GET['Id']);
    echo "1";
} else echo "0";