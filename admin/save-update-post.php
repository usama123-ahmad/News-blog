<?php
include "config.php";
if(empty($_FILES['new-image']['name']))
{
  $img= $_POST['old-image'];
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
    $new_image= time(). "-".basename($file_name);
    $target="upload/".$new_image;
    $img=$new_image;
    if(empty($errors) == true){
        move_uploaded_file($file_tmp,$target);
    }else{
        print_r($errors);
        die();
    }
}
echo $sql="UPDATE post SET title='{$_POST["post_title"]}', description='{$_POST["postdesc"]}', category={$_POST['category']}, post_img='{$img}'
WHERE post_id={$_POST['post_id']};";
if($_post['old-name'] != $_POST['category']){
$sql.="UPDATE category SET post=post-1 WHERE category_id ={$_POST['old-value']};";
$sql.="UPDATE category SET post=post+1 WHERE category_id ={$_POST['category']}";
}
$result=mysqli_multi_query($conn,$sql);
if($result){
    header("Location:{$hostname}/admin/post.php"); 
}else
{
    echo "Query Failed";
}
?>