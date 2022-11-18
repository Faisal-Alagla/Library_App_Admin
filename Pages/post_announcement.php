<?php
include('../includes/header.php');

$current_announcement = "";
if ($_SESSION['announcement_exists']) {
    $current_announcement = $_SESSION['announcement'];
}
?>

<div class="row container-fluid p-0 m-0">
    <div class="col-sm-12 p-0 my-5">
        <div class="container p-0 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                    <div class="card shadow-lg" style=" border-radius: 20px">
                        <!--start of form card-->
                        <form class="card-body p-5 text-center" method="POST"
                            action="../db/post_announcement_action.php">
                            <h3 class="mb-5" style=" color:#212B5E; ">Post Announcement</h3>
                            <div class="mb-4 text-end">
                                <!-- text field start -->
                                <div class="input mb-4 text-end mt-3">
                                    <textarea type="input" name="announcement" rows="10" id="announcement"
                                        class="form-control form-control-lg shadow-lg rows"
                                        style="border-radius: 15px;"><?php echo $current_announcement ?></textarea>
                                </div>
                                <!-- text field end -->
                            </div>

                            <?php
                            if (isset($_SESSION['post_announcement'])) {
                                $post_msg = $_SESSION['post_announcement'];

                                if ($post_msg == 'Announcement updated!' || $post_msg == 'Announcement added!') {
                                    $msg_color = "text-success";
                                } else {
                                    $msg_color = "text-danger";
                                }

                            ?>

                            <p class="<?php echo $msg_color ?> ">
                                <?php echo $_SESSION['post_announcement'] ?>
                            </p>

                            <?php
                            }
                            unset($_SESSION['post_announcement']);
                            ?>

                            <button class="btn btn-lg btn-block text-white w-50 display-2 mb-3 "
                                style="background-color: #212B5E; border-radius: 15px" name="submit" type="submit">

                                <?php
                                if ($_SESSION['announcement_exists']) {
                                    echo "Update";
                                } else {
                                    echo "Submit";
                                }
                                ?>

                            </button>

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