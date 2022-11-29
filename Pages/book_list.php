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

                            <!-- Search bar start -->
                            <!-- <div class="col-sm-4 d-flex flex-column justify-content-center align-self-center m-2">
                                <label class="text-start" for="search">Search Book</label>
                                <div class="d-flex flex-row">
                                    <form role="search" class="border-dark">
                                        <input type="text" placeholder="Search..." id="myInput"
                                            class="form-control mt-0">
                                    </form>
                                </div>
                            </div> -->
                            <!-- Search bar end -->

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
                                    <table class="table table-dark table-hover text-center align-items-center" id="paginated">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center pe-1">#</th>
                                                <th scope="col" class="text-center pe-1">ISBN</th>
                                                <th scope="col" class="text-center pe-1">Title</th>
                                                <th scope="col" class="text-center pe-1">Author</th>
                                                <th scope="col" class="text-center pe-1">Category</th>
                                                <th scope="col" class="text-center pe-1">Image</th>
                                                <th scope="col" class="text-center pe-1">Publish Date</th>
                                                <!-- <th scope="col">Summary</th> -->
                                                <th scope="col" class="text-center pe-1" style="width: 7%;">Edit</th>
                                                <th scope="col" class="text-center pe-1" style="width: 7%;">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody id="myTable">

                                            <?php
                                            //fetching data from the books table
                                            $ref_table = 'books';
                                            $fetch_books = $database->getReference($ref_table)->getValue();

                                            //displaying table rows
                                            if ($fetch_books > 0) {
                                                $num = 1;
                                                foreach ($fetch_books as $key => $row) {
                                                    if($row['image'] > 0){
                                                        $book_img_url = "https://firebasestorage.googleapis.com/v0/b/".$bucket_name."/o/images%2F".$row['image']."?alt=media";
                                                    } else{
                                                        $book_img_url = "";
                                                    }
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $num++ ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['isbn'] ?>
                                                </td>
                                                <td id="title">
                                                    <?php echo $row['title'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['author'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['category'] ?>
                                                </td>
                                                <td>
                                                    <img src="<?php echo $book_img_url ?>" alt=""
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
                                                    <a class="btn text-white"
                                                        style="background-color: #3e51b1; border-radius: 5px"
                                                        href="edit_book.php?id=<?php echo $key ?>">
                                                        Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="btn text-white"
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