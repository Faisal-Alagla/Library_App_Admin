<?php
########################################
########################################
/* 
This File has nothing to do with the project
Its purpose is only for tesing stuff during development!
*/
########################################
########################################

include("config.php");
?>

<!-- <form action="" method="POST" enctype="multipart/form-data" name="ex_card" class="forms-sample">
    <div class="form-group">
        <label>IMG</label>
        <input type="file" name="img" class="file-upload-default">
    </div>

    <button type="submit" name="up-img" class="btn btn-primary me-2">Update</button>
</form> -->

<?php
//upload images
// if(isset($_POST['up-img'])) {
//     $image = $_FILES['img']['name'];
//     $file_contents = file_get_contents($_FILES['img']['tmp_name']);
//     $dir = 'requests_images/';

//     $bucket->upload($file_contents, ['name' => $dir.$image]);
// }


//get image urls
// $myimg = 'C9OQH-2w3g-1Ayj08mjYLwlpI46QAbxgtyqa.jpg';
// $dir = 'images%2F';
// $myimgurl = "https://firebasestorage.googleapis.com/v0/b/".$bucket_name."/o/".$dir.$myimg."?alt=media";


//delete images
// $bucket->object('images/'.$myimg)->delete();


//moving images
// $isbn = '342234243';
// $object = $bucket->object('requests_images/'.$myimg);
// $object->copy($bucket, ['name' => 'images/'.$isbn.$myimg]);
// $object->delete();
?>