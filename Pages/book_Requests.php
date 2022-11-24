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
                            // feedback message after accepting the book request
                            if (isset($_SESSION['book_accepted'])) {
                                $msg = $_SESSION['book_accepted'];

                                //message color changes wether the operation is successful or not
                                if ($_SESSION['book_accepted_flag']) {
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
                                unset($_SESSION['book_accepted']);
                                unset($_SESSION['book_accepted_flag']);
                            }

                            // feedback message after request decline
                            if (isset($_SESSION['book_declined'])) {
                                $msg = $_SESSION['book_declined'];

                                //message color changes wether the operation is successful or not
                                if ($_SESSION['book_declined_flag']) {
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
                                unset($_SESSION['book_declined']);
                                unset($_SESSION['book_declined_flag']);
                            }
                            
                            //error message if can't view request
                            if (isset($_SESSION['view_rquest_error'])) {
                                $msg = $_SESSION['view_rquest_error'];
                                $msg_color = "alert-danger";

                            ?>

                            <div class="alert <?php echo $msg_color ?>" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                //clearing session variables
                                unset($_SESSION['view_rquest_error']);
                            }
                            ?>

                            <div class="mb-4 mx-2">
                                <!-- Table start -->
                                <div class="mb-4 table-responsive">
                                    <table class="table table-dark table-hover text-center align-items-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">ISBN</th>
                                                <th scope="col">Title</th>
                                                <th scope="col" style="width: 10%;">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            //fetching data from the books table
                                            $ref_table = 'book_requests';
                                            $fetch_books = $database->getReference($ref_table)->getValue();

                                            //displaying table rows
                                            if ($fetch_books > 0) {
                                                $num = 1;
                                                foreach ($fetch_books as $key => $row) {
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
                                                    <a class="btn btn-sm btn-success w-100"
                                                        style="border-radius: 5px"
                                                        href="view_request.php?id=<?php echo $key ?>">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>

                                            <?php
                                                }
                                            }

                                            unset($ref_table);
                                            unset($fetch_books);
                                            ?>


                                        </tbody>
                                    </table>
                                </div>
                                <!-- Table end -->
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