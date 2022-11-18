<?php
session_start();
include("config.php");

$ref_table = "announcements";
$fetch_announcement = $database->getReference($ref_table)->getValue();

if ($fetch_announcement > 0) {
  $announcement_key = $database->getReference($ref_table)->getChildKeys()[0];

  $_SESSION['announcement_exists'] = true;
  $_SESSION['announcement'] = $fetch_announcement[$announcement_key]['announcement'];

  // foreach($fetch_announcement as $key => $row){
  //   echo $row['announcement'];
  //   //echo hr here (later if there're many announcements)
  //   //if only 1 announcement -> no need to loop
  // }
} else {
  $_SESSION['announcement_exists'] = false;
  $_SESSION['announcement'] = "There are currently no accouncement(s)";
}

switch ($_SESSION['coming_from']) {
  case 'login':
    unset($_SESSION['coming_from']);
    header('location: ../pages/home.php');
    break;
  case 'post_announcement':
    unset($_SESSION['coming_from']);
    header('location: ../pages/post_announcement.php');
    break;
  default:
    header('location: ../index.php');
}
?>