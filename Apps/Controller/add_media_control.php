<?php
require_once '../Libs/Media.php';

//func get count total images
function count_dir_files($dirname)
{
    $total_files=0;
    if(is_dir($dirname))
    {
        $dp=opendir($dirname);
        if($dp)
        {
            while(($filename=readdir($dp)) == true)
            {
                if(($filename !=".") && ($filename !=".."))
                {
                    $total_files++;
                }
            }
        }
    }
    return $total_files;
}

function add_images($productId, $images = []){
    if(isset($productId) && is_numeric($productId) && is_array($images) && count($images) > 0){
        $total_files_dir  = count_dir_files('../../Media/Images')+1;
        $len = count($images['name']);
        $media = new Media();
        $index = count($media->getImages($productId));
        for ($i = 0; $i < $len; $i++)
            if($images['name'][$i] != ''){
                $file_name = "image-".($total_files_dir + $i).str_replace("image/",".",$images['type'][$i]);
                move_uploaded_file($images["tmp_name"][$i], "../../Media/Images/".$file_name);
                $media->addImage([":productId"=>$productId, ":url"=>$file_name, ":index"=>$index+$i]);
            }
    }
}