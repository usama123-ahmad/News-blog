<?php
include "config.php";
if(empty($_FILES['new-image']['name']))
{
  $file_name= $_POST['old-image'];
}
else
{
    $errors=array();
    $file_name=$_FILES['new-image']['name'];
    $file_size=$_FILES['new-image']['size'];
    $file_tmp=$_FILES['new-image']['tmp_name'];
    $file_type=$_FILES['new-image']['type'];
    $file_ext= end(explode('.',$file_name));
    $extensions=array('jpeg','jpg','png');
    if(in_array($file_ext,$extensions)===false){
     $errors[]="this format is not allowed";
    }
    if($file_size > 2097152)
    {
       $errors[]="file size should be less than 2mb";
    }
    if(empty($errors) == true){
        move_uploaded_file($file_tmp,"images/".$file_name);
    }else{
        print_r($errors);
        die();
    }
}
echo $sql="UPDATE settings SET websitename='{$_POST["webname"]}',logo='{$file_name}', footerdesc='{$_POST["footerdesc"]}'";
$result=mysqli_query($conn,$sql);
if($result){
    header("Location:{$hostname}/admin/settings.php"); 
}else
{
    echo "Query Failed";
}
?>