<?php
include("../db/config.php");
include('../includes/header.php');

?>


<div class="row container-fluid p-0 m-0">
    <div class="col-sm-12 p-0 my-5">
        <div class="container p-0 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card shadow-lg" style=" border-radius: 20px">
                        <!--start of card-->
                        <form class="card-body p-5 pb-2 text-center" method="" action="">
                            <h3 class="mb-5 fw-bold" style=" color:#212B5E; ">Library Books</h3>
                            <div class="col-sm-4 d-flex flex-column justify-content-center align-self-center">
                                <form>
                                    <label class="text-start" for="search">Search by Book Title</label>
                                    <div class="d-flex flex-row">
                                        <input class="form-control me-2 border-dark" type="search" placeholder="Search title..." aria-label="Search">
                                        <button class="btn btn-outline-dark" type="submit">Search</button>
                                    </div>
                                </form>
                            </div>

                            <?php
                                if (isset($_SESSION['book_deleted'])) {
                                    $msg = $_SESSION['book_deleted'];

                                    if ($_SESSION['book_deleted_flag']) {
                                        $msg_color = "text-success";
                                    } else {
                                        $msg_color = "text-danger";
                                    }

                                ?>

                                    <p class="mx-5 <?php echo $msg_color ?> ">
                                        <?php echo $msg; ?>
                                    </p>

                                <?php
                                    unset($_SESSION['book_deleted']);
                                    unset($_SESSION['book_deleted_flag']);
                                }
                                ?>

                            <div class="mb-4 mx-5">
                                <!-- Table start -->
                                <div class="mb-4 table-responsive">
                                    <table class="table table-dark table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">ISBN</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Author</th>
                                                <th scope="col">Publish Date</th>
                                                <!-- <th scope="col">Summary</th> -->
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ref_table = 'books';
                                            $fetch_books = $database->getReference($ref_table)->getValue();

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
                                                            <?php echo $row['image'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['author'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['date'] ?>
                                                        </td>
                                                        <!-- <td>
                                                            <?php #echo $row['summary'] 
                                                            ?>
                                                        </td> -->
                                                        <td>
                                                            <a class="btn btn-sm text-white w-100" style="background-color: #3e51b1; border-radius: 5px" href="edit_book.php?id=<?php echo $key ?>">
                                                                Edit
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-danger btn-sm" href="../db/delete_book_action.php?id=<?php echo $key ?>">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>

                                            <?php
                                                }
                                            }

                                            ?>


                                        </tbody>
                                    </table>
                                </div>
                                <!-- Table end -->
                            </div>
                        </form>
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