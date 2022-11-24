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
                            <h3 class="mb-5 fw-bold" style=" color:#212B5E; ">Manage Books</h3>

                            <!--############ FOR SEARCH CONSIDER DATALIST! ###############-->
                            <!-- <div class="col-sm-4 d-flex flex-column justify-content-center align-self-center">
                                <form>
                                    <label class="text-start" for="search">Search by Book Title</label>
                                    <div class="d-flex flex-row">
                                        <input class="form-control me-2 border-dark" type="search" placeholder="Search..." aria-label="Search">
                                        <button class="btn btn-outline-dark" type="submit">Search</button>
                                    </div>
                                </form>
                            </div> -->

                            <?php
                            //feedback message after book deletion
                            if (isset($_SESSION['book_deleted'])) {
                                $msg = $_SESSION['book_deleted'];

                                //message color changes wether deletion is successful or failed
                                if ($_SESSION['book_deleted_flag']) {
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
                                unset($_SESSION['book_deleted']);
                                unset($_SESSION['book_deleted_flag']);
                            }

                            //error message if can't edit book
                            if (isset($_SESSION['edit_book_error'])) {
                                $msg = $_SESSION['edit_book_error'];
                                $msg_color = "alert-danger";

                            ?>

                            <div class="alert <?php echo $msg_color ?>" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                //clearing session variables
                                unset($_SESSION['edit_book_error']);
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
                                                <th scope="col">Author</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Publish Date</th>
                                                <!-- <th scope="col">Summary</th> -->
                                                <th scope="col" style="width: 7%;">Edit</th>
                                                <th scope="col" style="width: 7%;">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            //fetching data from the books table
                                            $ref_table = 'books';
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
                                                    <?php echo $row['author'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['category'] ?>
                                                </td>
                                                <td>
                                                    <img src="../images/book_images/<?php echo $row['image'] ?>" alt=""
                                                        style="max-width: 45px;">
                                                </td>
                                                <td>
                                                    <?php echo $row['date'] ?>
                                                </td>
                                                <!-- <td>
                                                            <?php #echo $row['summary'] 
                                                            ?>
                                                        </td> -->
                                                <td>
                                                    <a class="btn btn-sm text-white w-100"
                                                        style="background-color: #3e51b1; border-radius: 5px"
                                                        href="edit_book.php?id=<?php echo $key ?>">
                                                        Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm text-white w-100"
                                                        style="background-color: #98030e; border-radius: 5px"
                                                        href="../db/delete_book_action.php?id=<?php echo $key ?>">
                                                        Delete
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