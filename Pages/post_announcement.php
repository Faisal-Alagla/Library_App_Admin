<?php
include('../includes/header.php');

$ref_table = "announcements";
$fetch_announcement = $database->getReference($ref_table)->getValue();

if ($fetch_announcement > 0) {
    $announcement_key = $database->getReference($ref_table)->getChildKeys()[0];
    $announcement = $fetch_announcement[$announcement_key]['announcement'];

    $current_announcement =  $announcement;
    $card_title = "Update";
    // $_SESSION['announcement_exists'] = true;
} else {
    $current_announcement = "";
    $card_title = "Post";
    // $_SESSION['announcement_exists'] = false;
}

$ref_table = "";
$fetch_announcement = "";
?>

<div class="row container-fluid p-0 m-0">
    <div class="col-sm-12 p-0 my-5">
        <div class="container p-0 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card shadow-lg" style=" border-radius: 20px">
                        <!--start of form card-->
                        <form class="card-body d-flex flex-column p-5 text-center" method="POST" action="../db/post_announcement_action.php">
                            <h3 class="mb-5 fw-bold" style=" color:#212B5E; "><?php echo $card_title ?> Announcement</h3>
                            <div class="mb-4 text-end">
                                <!-- text field start -->
                                <div class="input mb-4 text-end mt-3">
                                    <textarea type="text" name="announcement" rows="10" id="announcement" class="form-control form-control-lg shadow-lg rows" style="border-radius: 15px;"><?php echo $current_announcement ?></textarea>
                                </div>
                                <!-- text field end -->
                            </div>

                            <?php
                            if (isset($_SESSION['post_announcement'])) {
                                $msg = $_SESSION['post_announcement'];

                                if ($_SESSION['post_announcement_flag']) {
                                    $msg_color = "text-success";
                                } else {
                                    $msg_color = "text-danger";
                                }

                            ?>

                                <p class="<?php echo $msg_color ?> ">
                                    <?php echo $msg; ?>
                                </p>

                            <?php
                                unset($_SESSION['post_announcement']);
                                unset($_SESSION['post_announcement_flag']);
                            }
                            ?>

                            <div class="col-sm-12 row justify-content-center align-self-center">
                                <div class="col-sm-6 px-1">

                                    <button class="btn btn-lg btn-block text-white w-100 display-2 mb-3" style="background-color: #212B5E; border-radius: 15px" name="post" type="post">

                                        <?php
                                        if ($_SESSION['announcement_exists']) {
                                            echo "Update";
                                        } else {
                                            echo "Submit";
                                        }
                                        ?>

                                    </button>
                                </div>

                                <?php
                                if ($_SESSION['announcement_exists']) {
                                ?>
                                    <div class="col-sm-6 px-1">
                                        <button class="btn btn-lg btn-block text-white w-100 display-2 mb-3 " style="background-color: #98030e; border-radius: 15px" name="delete" type="delete">
                                            Delete
                                        </button>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>

                        </form>
                        <!--end of form card-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../includes/footer.php');
?>