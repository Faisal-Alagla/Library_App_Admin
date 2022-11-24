<?php
include('../includes/header.php');

$user = $auth->getUser($_SESSION['verified_user_id']);
?>

<div class="container-fluid p-0 m-0">
    <div class="my-5">
        <div class="container p-0">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-11 col-lg-10 col-xl-9">
                    <div class="card shadow-lg" style="border-radius: 20px">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5 fw-bold" style="color:#212B5E;">Profile</h3>

                            <?php
                            //display name updated successfully
                            if (isset($_SESSION['dName_updated'])) {
                                $msg = $_SESSION['dName_updated'];
                            ?>

                            <div class="alert alert-success" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                unset($_SESSION['dName_updated']);
                            }

                            //some error occured
                            if (isset($_SESSION['profile_error'])) {
                                $msg = $_SESSION['profile_error'];
                            ?>

                            <div class="alert alert-danger" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                unset($_SESSION['profile_error']);
                            }
                            ?>

                            <!-- Display name start -->
                            <div class="col-sm-12 d-flex justify-content-center mb-4 text-start">
                                <div class="mb-3 mt-3 text-start input" style="min-width: 50%;">
                                    <label class="form-label" for="dName" style="color:#212B5E;">Display Name</label>

                                    <?php
                                    //when trying to edit
                                    if (isset($_GET['edit'])) {
                                    ?>

                                    <form method="POST" action="../db/profile_management.php">
                                        <input type="hidden" name="id" value="<?php echo $user->uid ?>" />
                                        <input type="text" id="dName" name="dName"
                                            class="form-control form-control-lg shadow-lg "
                                            style="border-radius: 15px; padding-right: 40px;"
                                            value="<?php echo $user->displayName ?>" required />
                                        <i class="bi bi-person-fill"></i>

                                        <div class="d-flex flex-row justify-content-evenly align-items-center mt-2">
                                            <button class="btn btn-lg btn-block text-white w-50 display-2 mx-1 "
                                                style="background-color: #212B5E; border-radius: 15px"
                                                type="update_dName" name="update_dName">
                                                Update
                                            </button>

                                            <a class="btn btn-lg btn-block text-white w-50 display-2 mx-1 "
                                                style="background-color: #98030e; border-radius: 15px"
                                                href="profile.php">
                                                Cancel
                                            </a>
                                        </div>
                                    </form>

                                    <?php
                                    } 
                                    //normal display
                                    else {
                                    ?>

                                    <div class="edit">
                                        <hr class="mt-0">
                                        <h3><?php echo $user->displayName ?></h3>
                                        <a href="profile.php?edit=edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>

                                    <?php

                                    }
                                    ?>

                                </div>
                            </div>
                            <!-- Display name end -->

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