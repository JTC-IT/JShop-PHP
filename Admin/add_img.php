<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload File</title>
</head>
<body>
<?php
if(isset($_POST['upload'])){
    var_dump($_FILES);
    if(isset($_FILES['file'])){
        if(!$_FILES['file']['error']){
            move_uploaded_file($_FILES['file']["tmp_name"], "../Media/Images/".$_FILES['file']['name']);
            echo 'Upload successfully!';
        } else {
            echo 'Error: '.$_FILES['file']['error'];
        }
    } else {
        echo 'Error: No input';
    }
    die();
}
?>
<form action="add_img.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" accept="image/*"/>
    <br><!-- comment -->
    <input type="submit" name="upload" value="Upload" /><!-- submits -->
</form>
</body>
</html>