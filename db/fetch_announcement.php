<?php
$ref_table = "announcements";
$fetch_announcement = $database->getReference($ref_table)->getValue();

if($fetch_announcement > 0){
  foreach($fetch_announcement as $key => $row){
    echo $row['announcement'];
    //echo hr here (later if there're many announcements)
    //if only 1 announcement -> no need to loop
  }
}else{
  echo "There are currently no accouncement(s)";
}
?>