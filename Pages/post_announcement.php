<?php
include('../includes/header.php');

//fetching the announcements
$ref_table = "announcements";
$fetch_announcements = $database->getReference($ref_table)->getValue();

if ($fetch_announcements > 0) {
    $announcements = current($fetch_announcements);
    $announcements_key = array_keys($fetch_announcements)[0];

    //everyone announcement
    if(isset($announcements['everyone'])){
        $everyone_announcement = $announcements['everyone'];
    }else{
        $everyone_announcement = "";
    }
    //students announcement
    if(isset($announcements['students'])){
        $students_announcement = $announcements['students'];
    }else{
        $students_announcement = "";
    }
    //staff announcement
    if(isset($announcements['staff'])){
        $staff_announcement = $announcements['staff'];
    }else{
        $staff_announcement = "";
    }

    unset($announcements);
//no announcements
} else {
    $everyone_announcement = "";
    $students_announcement = "";
    $staff_announcement = "";
}

unset($ref_table);
unset($fetch_announcements);
?>

<div class="row container-fluid p-0 m-0">
    <div class="col-sm-12 p-0 my-5">
        <div class="container p-0 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card shadow-lg" style=" border-radius: 20px">
                        <!--card start-->
                        <div class="card-body d-flex flex-column p-5 text-center">
                            <h3 class="mb-5 fw-bold" style="color:#212B5E;">Post Announcements</h3>

                            <?php
                            //feedback message after posting / updating announcements
                            if (isset($_SESSION['post_announcement'])) :
                                $msg = $_SESSION['post_announcement'];

                                if ($_SESSION['post_announcement_flag']) {
                                    $msg_color = "alert-success";
                                } else {
                                    $msg_color = "alert-danger";
                                }

                            ?>

                            <div class="alert <?php echo $msg_color ?>" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                unset($_SESSION['post_announcement']);
                                unset($_SESSION['post_announcement_flag']);
                            endif;

                            //when choosing target announcement audience: default is "everyone"
                            $selected_decoration = "underline fw-bold fs-3";
                            if(isset($_GET['announcement'])){
                                $everyone_decoration = "none";
                                $students_decoration = "none";
                                $staff_decoration = "none";

                                switch($_GET['announcement']){
                                    case "students":
                                        $students_decoration = $selected_decoration;
                                        $post_audience = "students";
                                        $cur_announcement = $students_announcement;
                                        break;
                                    case "staff":
                                        $staff_decoration = $selected_decoration;
                                        $post_audience = "staff";
                                        $cur_announcement = $staff_announcement;
                                        break;
                                    default:
                                        $everyone_decoration = $selected_decoration;
                                        $post_audience = "everyone";
                                        $cur_announcement = $everyone_announcement;
                                    }
                                }else{
                                    $everyone_decoration = $selected_decoration;
                                    $post_audience = "everyone";
                                    $cur_announcement = $everyone_announcement;
                                }
                            ?>
                            
                            <!--Announcement audience choices start-->
                            <div class="d-flex flex-row justify-content-evenly align-items-center">
                                <a class="text-decoration-<?php echo $everyone_decoration ?>" style="color:#212B5E;" href="post_announcement.php?announcement=everyone">
                                    Everyone
                                </a>
                                <a class="text-decoration-<?php echo $students_decoration ?>" style="color:#212B5E;" href="post_announcement.php?announcement=students">
                                    Students
                                </a>
                                <a class="text-decoration-<?php echo $staff_decoration ?>" style="color:#212B5E;" href="post_announcement.php?announcement=staff">
                                    Staff
                                </a>
                            </div>
                            <!--Announcement audience choices end-->

                            <!--Form start-->
                            <form method="POST" action="../db/post_announcement_action.php">
                                <input type="hidden" name="audience" value="<?php echo $post_audience ?>" />
                                
                                <div class="mb-4 text-end">
                                    <!-- text field start -->
                                    <div class="input mb-4 text-end mt-3">
                                        <textarea type="text" name="announcement" rows="10" id="announcement"
                                        class="form-control form-control-lg shadow-lg rows"
                                        style="border-radius: 15px;"><?php echo $cur_announcement; ?></textarea>
                                    </div>
                                    <!-- text field end -->
                                </div>
                                
                                <div class="col-sm-12 d-flex flex-row justify-content-center align-self-center">
                                    <div class="col-sm-6 px-1">
                                        
                                        <button class="btn btn-lg btn-block text-white w-100 display-2 mb-3"
                                        style="background-color: #212B5E; border-radius: 15px" name="post" type="post">
                                            <?php (strlen(trim($cur_announcement, " ")) > 0) ? print "Update" : print "Post" ?>
                                        </button>
                                </div>
                                
                                <?php
                                    if (strlen(trim($cur_announcement, " ")) > 0) :
                                        ?>
                                    <div class="col-sm-6 px-1">
                                        <button class="btn btn-lg btn-block text-white w-100 display-2 mb-3 "
                                        style="background-color: #98030e; border-radius: 15px" name="delete"
                                        type="delete">
                                        Delete
                                    </button>
                                </div>
                                <?php
                                    endif;
                                ?>
                                </div>
                            </form>
                            <!--Form end-->
                        </div>
                        <!--card end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../includes/footer.php');
?>