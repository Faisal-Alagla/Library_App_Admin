<?php
session_start();
include("config.php");

$ref_table = "announcements";
$fetch_announcement = $database->getReference($ref_table)->getValue();

if($fetch_announcement > 0){
  $announcement_key = $database->getReference($ref_table)->getChildKeys()[0];
  echo $fetch_announcement[$announcement_key]['announcement'];
  
  $_SESSION['announcement_exists'] = true;


  // foreach($fetch_announcement as $key => $row){
  //   echo $row['announcement'];
  //   //echo hr here (later if there're many announcements)
  //   //if only 1 announcement -> no need to loop
  // }
}else{
  $_SESSION['announcement_exists'] = false;
  echo "There are currently no accouncement(s)";
}
?>