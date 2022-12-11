<?php
include('../includes/header.php');

$workhours_list = [
    "12:00",
    "12:30",
    "1:00",
    "1:30",
    "2:00",
    "2:30",
    "3:00",
    "3:30",
    "4:00",
    "4:30",
    "5:00",
    "5:30",
    "6:00",
    "6:30",
    "7:00",
    "7:30",
    "8:00",
    "8:30",
    "9:00",
    "9:30",
    "10:00",
    "10:30",
    "11:00",
    "11:30",
];
$days_list = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday"
];

$key = $database->getReference("announcements")->getChildKeys()[0];
$ref_table = "announcements/$key";
$fetch_working_hours = $database->getReference($ref_table)->getValue();


//if closed for maintenance or couldn't fetch -> set to Friday 12:00 AM as default
$from = "12:00";
$from_ampm = "AM";
$to = "12:00";
$to_ampm = "AM";
$from_day = "Friday";
$to_day = "Friday";
$closed = "The Library is closed";

if ($fetch_working_hours > 0) {
    if ($fetch_working_hours['workingHours'] != $closed) {
        //if not closed for maintenance -> fetch working hours
        $from_day = $fetch_working_hours['from_day'];
        $to_day = $fetch_working_hours['to_day'];
        $from = $fetch_working_hours['from'];
        $from_ampm = $fetch_working_hours['from_ampm'];
        $to = $fetch_working_hours['to'];
        $to_ampm = $fetch_working_hours['to_ampm'];
    } else {
        if (!isset($_SESSION['workhours_update'])) {
            $_SESSION['workhours_update'] = $closed;
            $_SESSION['workhours_update_flag'] = false;
        }
    }
}
?>

<div class="container-fluid p-0 m-0">
    <div class="my-5">
        <div class="container p-0">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-11 col-lg-10 col-xl-9">
                    <div class="card shadow-lg" style="border-radius: 20px">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5 fw-bold" style="color:#212B5E;">Manage Working Hours</h3>

                            <!--horizontal line-->
                            <div class="d-flex justify-content-center align-items-center">
                                <hr class="w-50" />
                            </div>

                            <?php
                            //feedback message
                            if (isset($_SESSION['workhours_update'])) :
                                $msg = $_SESSION['workhours_update'];

                                if ($_SESSION['workhours_update_flag']) {
                                    $msg_color = "alert-success";
                                } else {
                                    $msg_color = "alert-danger";
                                }
                            ?>

                                <div class="alert <?php echo $msg_color ?>" role="alert">
                                    <?php echo $msg ?>
                                </div>

                            <?php
                                unset($_SESSION['workhours_update']);
                                unset($_SESSION['workhours_update_flag']);
                            endif;
                            ?>

                            <h4 class="mt-5 fw-bold" style="color:#212B5E;">Set Working Hours</h4>
                            <!-- Change Working hours start -->
                            <div class="col-sm-12 d-flex justify-content-center mb-4 text-start">
                                <div class="mb-3 mt-3 text-start input w-75">
                                    <form method="POST" action="../db/working_hours_action.php">

                                        <div class="input col-sm-12 row">
                                            <!--Time From start-->
                                            <div class="col-sm-6 ps-5 pe-0">
                                                <label class="form-label" for="from" style="color:#212B5E;">From</label>
                                                <div class="input col-sm-12 row">

                                                    <!-- select days from -->
                                                    <div class="col-sm-12 pe-3">
                                                        <select id="from_day" name="from_day" class="form-control form-control-lg shadow-lg form-select text-center fs-5 mb-2" style="border-radius: 15px;">

                                                            <?php
                                                            foreach ($days_list as $option) :
                                                                $selected = "";
                                                                if ($option == $from_day) {
                                                                    $selected = "selected";
                                                                }
                                                            ?>

                                                                <option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>

                                                            <?php
                                                            endforeach;
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-sm-7 pe-0">
                                                        <!-- select hours from -->
                                                        <select id="from" name="from" class="form-control form-control-lg shadow-lg form-select text-center fs-5" style="border-radius: 15px;">

                                                            <?php
                                                            foreach ($workhours_list as $option) :
                                                                $selected = "";
                                                                if ($option == $from) {
                                                                    $selected = "selected";
                                                                }
                                                            ?>

                                                                <option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>

                                                            <?php
                                                            endforeach;
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-sm-5 pe-3">
                                                        <select id="from_AMPM" name="from_AMPM" class="form-control form-control-lg shadow-lg form-select text-center fs-5" style="border-radius: 15px;">
                                                            <option value="AM" <?php $from_ampm == "AM" ? print "selected" : print ""; ?>>AM</option>
                                                            <option value="PM" <?php $from_ampm == "PM" ? print "selected" : print ""; ?>>PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Time From End-->

                                            <!--Time To start-->
                                            <div class="col-sm-6 ps-5 pe-0">
                                                <label class="form-label" for="to" style="color:#212B5E;">To</label>
                                                <div class="input col-sm-12 row">

                                                    <!-- select days to -->
                                                    <div class="col-sm-12 pe-3">
                                                        <select id="to_day" name="to_day" class="form-control form-control-lg shadow-lg form-select text-center fs-5 mb-2" style="border-radius: 15px;">

                                                            <?php
                                                            foreach ($days_list as $option) :
                                                                $selected = "";
                                                                if ($option == $to_day) {
                                                                    $selected = "selected";
                                                                }
                                                            ?>

                                                                <option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>

                                                            <?php
                                                            endforeach;
                                                            ?>

                                                        </select>
                                                    </div>

                                                    <div class="col-sm-7 pe-0">
                                                        <!-- select hours to -->
                                                        <select id="to" name="to" class="form-control form-control-lg shadow-lg form-select text-center fs-5" style="border-radius: 15px;">

                                                            <?php
                                                            foreach ($workhours_list as $option) :
                                                                $selected = "";
                                                                if ($option == $to) {
                                                                    $selected = "selected";
                                                                }
                                                            ?>

                                                                <option value="<?php echo $option; ?>" <?php echo $selected; ?>><?php echo $option; ?></option>

                                                            <?php
                                                            endforeach;
                                                            ?>

                                                        </select>
                                                    </div>
                                                    <div class="col-sm-5 pe-3">
                                                        <select id="to_AMPM" name="to_AMPM" class="form-control form-control-lg shadow-lg form-select text-center fs-5" style="border-radius: 15px;">
                                                            <option value="AM" <?php $to_ampm == "AM" ? print "selected" : print ""; ?>>AM</option>
                                                            <option value="PM" <?php $to_ampm == "PM" ? print "selected" : print ""; ?>>PM</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Time To End-->
                                        </div>

                                        <div class="d-flex flex-row justify-content-evenly align-items-center mt-4 pt-2">
                                            <button class="btn btn-lg btn-block text-white display-2 mx-1 " style="background-color: #212B5E; border-radius: 15px; width: 40%" type="update_workhours" name="update_workhours">
                                                Update
                                            </button>
                                            <button class="btn btn-lg btn-block text-white display-2 mx-1 " style="background-color: #98030e; border-radius: 15px;  width: 40%" type="close_library" name="close_library">
                                                Close the Library
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Change Working hours end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include('../includes/footer.php');
?>