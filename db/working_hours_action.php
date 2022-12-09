<?php
include("config.php");

//update working hours
if(isset($_POST['update_workhours'])){
    $from_day = $_POST['from_day'];
    $to_day = $_POST['to_day'];
    $from = $_POST['from'];
    $from_ampm = $_POST['from_AMPM'];
    $to = $_POST['to'];
    $to_ampm = $_POST['to_AMPM'];

    //check if opening and closing times are the same
    if(!($from == $to) || !($from_ampm == $to_ampm)){
        //they're not the same -> update the announcements table with the new working hours
        
        $updateData = [
            'workingHours' => "From $from_day to $to_day at $from $from_ampm  -  $to $to_ampm",
            'from' => $from,
            'from_ampm' => $from_ampm,
            'to' => $to,
            'from_day' => $from_day,
            'to_day' => $to_day,
            'to_ampm' => $to_ampm
        ];
        
        $ref_table = "announcements/-NI85zuxnOIZW6ngSJyN";
        $database->getReference($ref_table)->update($updateData);

        $_SESSION['workhours_update'] = "Working hours have been updated!";
        $_SESSION['workhours_update_flag'] = true;
    }else{
        //time is the same -> send error message
        $_SESSION['workhours_update'] = "Opening and closing times can't be the same";
        $_SESSION['workhours_update_flag'] = false;
    }

//close library for maintenance
}else if (isset($_POST['close_library'])){
    $ref_table = "announcements/-NI85zuxnOIZW6ngSJyN/workingHours";
    $fetch_working_hours = $database->getReference($ref_table)->getValue();

    if($fetch_working_hours != "The Library is closed for maintenance"){
        //close for maintenance... -> set default values 12:00 AM
        $updateData = [
            'workingHours' => "The Library is closed for maintenance",
            'from' => "12:00",
            'from_ampm' => "AM",
            'to' => "12:00",
            'to_ampm' => "AM"
        ];
        
        $ref_table = "announcements/-NI85zuxnOIZW6ngSJyN";
        $database->getReference($ref_table)->update($updateData);

        $_SESSION['workhours_update'] = "The Library has been closed for maintenance";
        $_SESSION['workhours_update_flag'] = true;
    }else{
        //library is already closed...
        $_SESSION['workhours_update'] = "The Library is already closed for maintenance";
        $_SESSION['workhours_update_flag'] = false;
    }

//error case (no post)
}else{
    $_SESSION['workhours_update'] = "Soemthing went wrong, try again please";
    $_SESSION['workhours_update_flag'] = false;
}

header('location: ../pages/manage_working_hours.php');