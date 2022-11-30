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
                            <h3 class="mb-5 fw-bold" style=" color:#212B5E; ">Book Requests</h3>

                            <?php
                            // feedback message after the request action
                            if (isset($_SESSION['book_request_msg'])) :
                                $msg = $_SESSION['book_request_msg'];

                                //message color changes wether the operation is successful or not
                                if ($_SESSION['book_request_flag']) {
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
                                unset($_SESSION['book_request_msg']);
                                unset($_SESSION['book_request_flag']);
                            endif;

                            //error message if can't view request
                            if (isset($_SESSION['view_request_error'])) :
                                $msg = $_SESSION['view_request_error'];
                                $msg_color = "alert-danger";

                            ?>

                            <div class="alert <?php echo $msg_color ?>" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                //clearing session variables
                                unset($_SESSION['view_request_error']);
                            endif;
                            ?>

                            <div class="mb-4 mx-2">

                                <?php
                                //fetching data from the requests table
                                $ref_table = 'book_requests';
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
                                                <th scope="col" class="text-center pe-1">ISBN</th>
                                                <th scope="col" class="text-center pe-1">Title</th>
                                                <th scope="col" class="text-center pe-1" style="width: 10%;">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                foreach ($fetch_rquests as $key => $row) {
                                                ?>

                                            <tr>
                                                <td>
                                                    <?php echo $num++ ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['isbn'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['title'] ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-success w-100" style="border-radius: 5px"
                                                        href="view_book_request.php?id=<?php echo $key ?>">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>

                                            <?php
                                                }
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
                                            There are currently no book requests
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