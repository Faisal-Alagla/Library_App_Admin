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



###
// $user_email = '219211287@psu.edu.sa';
// $isbn = '5345345345';

// $postData = [
//     'userEmail' => $user_email,
//     'isbn' => $isbn,
//     'title' => 'calculus 2',
//     'userKey' => '-NGuXMKMnOa4_ME8tspI'
// ];

// $ref_table = "borrow_requests";
// $database->getReference($ref_table)->push($postData);


###
// $today = date("Y-m-d");
// $borrowdays = 5;
// echo '<hr/>';

// echo date( "Y-m-d", strtotime("$today +$borrowdays day"));
// echo '<hr/>';

// echo date( "Y-m-d", strtotime( "$today +2 month" ) );


###
// $tomorrow = strtotime('+1 days');
// $yesterday = strtotime('-1 days');
// $due_date = strtotime(date('2022-12-02'));

// if($due_date >= $tomorrow){
//  echo "green";
// }else if(($due_date > $yesterday) && ($due_date < $tomorrow)){
//  echo "yellow";
// }else{
//  echo "red";
// }

###

$fetch_books = $database->getReference('books')->getValue();

foreach($fetch_books as $row){
    if($row['isbn'] == $isbn){
        $title = $row['title'];
        break;
    }
}
?>