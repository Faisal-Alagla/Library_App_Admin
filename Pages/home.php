<?php
include('../includes/header.php');

$user = $auth->getUser($_SESSION['verified_user_id']);
?>

<div class="container-fluid">
    <!--Welcome Messsage start-->
    <div class="d-flex justify-content-center align-items-center" style="height: 10vw">
        <h1 class="text-light fw-bold">Welcome,
            <?php echo $user->displayName ?>!
        </h1>
    </div>
    <!--Welcome Messsage end-->

    <!--horizontal line-->
    <div class="d-flex justify-content-center align-items-center" style="height: 5vw">
        <hr class="text-light w-50" />
    </div>

    <!--Announcements card start-->
    <div class="d-flex justify-content-center">
        <div class="card bg-dark" style="border-radius: 20px; width: 60%; min-width: 200px;">
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="text-center">
                    <h2 class="text-light">Current Announcements</h2>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 2vw">
                    <hr class="text-light w-50" />
                </div>
                
                <?php
                        //fetching announcements
                        $ref_table = "announcements";
                        $fetch_announcements = $database->getReference($ref_table)->getValue();
                        
                        if ($fetch_announcements > 0) {
                            //if there are announcements -> get them
                            //here: announcmeents should be an arrayof key-value pairs 
                            //['everyone' => 'announcement for everyone', 'students' => 'announcement for students', 'staff' => 'announcement for staff']
                            $announcements = current($fetch_announcements);
                            ?>

                            <!--Announcement for everyone start-->
                            <h2 class="text-light text-center mt-5 mb-3">For Everyone</h2>
                            <div class="bg-secondary" style="border-radius: 5px">
                                <p class="m-2 text-white" style="font-size: 18px;">
                                    
                                    <?php
                            if(isset($announcements['everyone'])) {
                                echo $announcements['everyone'];
                            } else {
                                echo "There is currently no accouncement(s)";
                            }
                            ?>
                            <!--Announcement for everyone end-->

                                </p>
                            </div>

                            <!--Announcement for students start-->
                            <h2 class="text-light text-center mt-5 mb-3">For Students</h2>
                            <div class="bg-secondary" style="border-radius: 5px">
                                <p class="m-2 text-white" style="font-size: 18px;">

                            <?php
                            if(isset($announcements['students'])) {
                                echo $announcements['students'];
                                } else {
                                echo "There is currently no accouncement(s)";
                            }
                            ?>

                                </p>
                            </div>
                            <!--Announcement for students end-->

                            <!--Announcement for staff start-->
                            <h2 class="text-light text-center mt-5 mb-3">For Staff</h2>
                            <div class="bg-secondary" style="border-radius: 5px">
                                <p class="m-2 text-white" style="font-size: 18px;">

                            <?php
                            if(isset($announcements['staff'])) {
                                echo $announcements['staff'];
                                } else {
                                echo "There is currently no accouncement(s)";
                            }
                            ?>

                                </p>
                            </div>
                            <!--Announcement for staff end-->

                        <?php
                            unset($announcements);
                        }
                        unset($ref_table);
                        unset($fetch_announcements);
                        ?>

            </div>
        </div>
    </div>
    <!--Announcement card end-->
</div>

<?php
include('../includes/footer.php');
?>