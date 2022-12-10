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

    <!--Working hours card start-->
    <div class="d-flex justify-content-center">
        <div class="card bg-dark" style="border-radius: 20px; width: 60%; min-width: 200px;">
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="text-center">
                    <h2 class="text-light">Current Working Hours</h2>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 2vw">
                    <hr class="text-light w-50" />
                </div>

                <?php
                //fetching working hours
                $ref_table = "announcements";
                $fetch_announcements = $database->getReference($ref_table)->getValue();

                if ($fetch_announcements > 0) {
                    //if there are announcements -> get them
                    //here: announcmeents should be an arrayof key-value pairs 
                    //['workingHours' => 'workingHours string', 'everyone' => 'announcement for everyone', 'students' => 'announcement for students', ...]
                    $announcements = current($fetch_announcements);
                ?>

                    <div class="bg-secondary" style="border-radius: 5px">
                        <p class="m-2 text-white text-center" style="font-size: 18px;">

                            <?php
                            if (isset($announcements['workingHours'])) {
                                echo $announcements['workingHours'];
                            } else {
                                echo "There is currently no working hours";
                            }
                            ?>

                        </p>
                    </div>

                <?php
                } else {
                ?>

                    <div class="bg-secondary" style="border-radius: 5px">
                        <p class="m-2 text-white" style="font-size: 18px;">
                            Working hours are not set yet
                        </p>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!--Working hours card end-->

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

                if ($fetch_announcements > 0) {
                    //if there are announcements -> get them
                ?>

                    <!--Announcement for everyone start-->
                    <h2 class="text-light text-center mt-5 mb-3">For Everyone</h2>
                    <div class="bg-secondary" style="border-radius: 5px">
                        <p class="m-2 text-white" style="font-size: 18px;">

                            <?php
                            if (isset($announcements['everyone'])) {
                                echo $announcements['everyone'];
                            } else {
                                echo "There is currently no accouncement(s)";
                            }
                            ?>

                        </p>
                    </div>
                    <!--Announcement for everyone end-->

                    <!--Announcement for students start-->
                    <h2 class="text-light text-center mt-5 mb-3">For Students</h2>
                    <div class="bg-secondary" style="border-radius: 5px">
                        <p class="m-2 text-white" style="font-size: 18px;">

                            <?php
                            if (isset($announcements['students'])) {
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
                            if (isset($announcements['staff'])) {
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
                } else {
                    //if there's no announcements at all
                ?>

                    <div class="bg-secondary" style="border-radius: 5px">
                        <p class="m-2 text-white" style="font-size: 18px;">
                            There is currently no announcements at all
                        </p>
                    </div>

                <?php
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