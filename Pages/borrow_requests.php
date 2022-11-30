<?php
include('../includes/header.php');

?>

<div class="row container-fluid p-0 m-0">
    <div class="col-sm-12 p-0 my-5">
        <div class="container p-0 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card shadow-lg" style=" border-radius: 20px">
                        <!--start of card-->
                        <div class="card-body p-5 pb-2 text-center">
                            <h3 class="mb-5 fw-bold" style=" color:#212B5E; ">Borrow Requests</h3>

                            <?php
                            //feedback message after action is done
                            if (isset($_SESSION['borrow_reuqest_accepted'])) {
                                $msg = $_SESSION['borrow_reuqest_accepted'];

                                //message color changes wether action is successful or failed
                                if ($_SESSION['borrow_request_flag']) {
                                    $msg_color = "alert-success";
                                } else {
                                    $msg_color = "alert-danger";
                                }

                            ?>

                            <div class="alert <?php echo $msg_color ?>" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                //clearing session variables
                                unset($_SESSION['borrow_reuqest_accepted']);
                                unset($_SESSION['borrow_request_flag']);
                            }
                            ?>

                            <div class="mb-4 mx-2">
                                <?php
                                //fetching data from the requests table
                                $ref_table = 'borrow_requests';
                                $fetch_rquests = $database->getReference($ref_table)->getValue();

                                //displaying requests table, if exists any
                                if ($fetch_rquests > 0) {
                                    $num = 1;
                                ?>

                                <!-- Table start -->
                                <div class="mb-4 table-responsive">
                                    <table class="table table-dark table-hover text-center align-items-center" id="paginated">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center pe-1">#</th>
                                                <th scope="col" class="text-center pe-1">Email</th>
                                                <th scope="col" class="text-center pe-1">ISBN</th>
                                                <th scope="col" class="text-center pe-1">Title</th>
                                                <th scope="col" class="text-center pe-1" style="width: 10%;">Accept</th>
                                                <th scope="col" class="text-center pe-1" style="width: 10%;">Decline</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                foreach ($fetch_rquests as $key => $row) :
                                                ?>

                                            <tr>
                                                <td>
                                                    <?php echo $num++ ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['userEmail'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['isbn'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['title'] ?>
                                                </td>
                                                <td>
                                                    <a class="btn text-white" style="background-color: #3e51b1; border-radius: 5px" href="../db/borrow_request_action.php?accept=<?php echo $key ?>">
                                                        Accept
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn text-light" style="background-color: #98030e; border-radius: 5px" href="../db/borrow_request_action.php?decline=<?php echo $key ?>">
                                                        Decline
                                                    </a>
                                                </td>
                                            </tr>

                                            <?php
                                                endforeach;
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- Table end -->

                                <?php
                                } else {
                                ?>

                                <!--No requests card-->
                                <div class="card shadow-lg" style=" border-radius: 20px">
                                    <div class="card-body p-5 pb-2 text-center">
                                        <h3 class="mb-5 fw-bold text-success" style=" color:#212B5E; ">
                                            There are currently no borrow requests
                                        </h3>
                                    </div>
                                </div>

                                <?php
                                }

                                unset($ref_table);
                                unset($fetch_rquests);
                                ?>

                            </div>
                        </div>
                        <!--end of card-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../includes/footer.php');
?>