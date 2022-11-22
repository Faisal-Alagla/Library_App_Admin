<?php
include('../includes/header.php');

?>

<div class="container-fluid p-0 m-0">

    <div class="my-5">
        <div class="container p-0">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                    <form class="card shadow-lg" style="border-radius: 20px" method="post" action="../db/edit_book_action.php" enctype="multipart/form-data">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-5 fw-bold" style="color:#212B5E;">Edit Book Information</h3>

                            <?php
                            if (isset($_SESSION['book_updated'])) {
                                $msg = $_SESSION['book_updated'];

                                if ($_SESSION['book_updated_flag']) {
                                    $msg_color = "alert-success";
                                } else {
                                    $msg_color = "alert-danger";
                                }

                            ?>

                                <div class="alert <?php echo $msg_color ?>" role="alert">
                                    <?php echo $msg ?>
                                </div>

                                <?php
                                unset($_SESSION['book_updated']);
                                unset($_SESSION['book_updated_flag']);
                            }

                            if (isset($_GET['id']) || isset($_SESSION['book_key'])) {
                                if (isset($_SESSION['book_key'])) {
                                    $book_key = $_SESSION['book_key'];
                                    unset($_SESSION['book_key']);
                                } else {
                                    $book_key = $_GET['id'];
                                }

                                $ref_table = 'books';
                                $book = $database->getReference($ref_table)->getChild($book_key)->getValue();

                                if ($book > 0) {

                                ?>

                                    <!-- Form start -->
                                    <div class="mb-4 text-start">

                                        <input type="hidden" name="key" value="<?php echo $book_key ?>" />
                                        <!-- ISBN Field start -->
                                        <div class=" mb-3 mt-3 text-start input">
                                            <label class="form-label" for="isbn" style="color:#212B5E;">ISBN</label>
                                            <input type="text" id="isbn" name="isbn" class="form-control form-control-lg shadow-lg " style="border-radius: 15px; padding-right: 40px;" minlength="10" maxlength="10" value="<?php echo $book['isbn'] ?>" required />
                                            <i class="bi bi-upc-scan"></i>
                                        </div>
                                        <!-- ISBN Field end -->

                                        <!-- Title Field start -->
                                        <div class="input">
                                            <label class="form-label" for="title" style="color:#212B5E;">Title</label>
                                            <input type="text" id="title" name="title" class="form-control form-control-lg shadow-lg" aria-describedby="basic-addon1" style="border-radius: 15px" value="<?php echo $book['title'] ?>" required />
                                            <i class="bi bi-card-heading"></i>
                                        </div>
                                        <!-- Title Field end -->

                                        <!-- Image Field start -->
                                        <div class="col-sm-12 d-flex flex-row justify-content-center align-items-center">
                                            <div class="input col-sm-9">
                                                <label class="form-label" for="image" style="color:#212B5E;">Image</label>
                                                <input type="file" id="image" name="image" class="form-control form-control-lg shadow-lg" aria-describedby="basic-addon1" value="<?php echo $book['image'] ?>" style="border-radius: 15px" />
                                                <i class="bi bi-card-image"></i>
                                            </div>
                                            <div class="col-sm-3 d-flex justify-content-center">
                                                <img class="pt-2" src="../images/book_images/<?php echo $book['image'] ?>" alt="" style="max-width: 45px;">
                                            </div>
                                        </div>
                                        <!-- Image Field end -->

                                        <!-- Author Field start -->
                                        <div class=" mb-3 mt-3 text-start input">
                                            <label class="form-label" for="author" style="color:#212B5E;">Author</label>
                                            <input type="text" id="author" name="author" class="form-control form-control-lg shadow-lg " value="<?php echo $book['author'] ?>" style="border-radius: 15px; padding-right: 40px;" />
                                            <i class="bi bi-vector-pen"></i>
                                        </div>
                                        <!-- Author Field end -->

                                        <!-- Category Field start -->
                                        <div class=" mb-3 mt-3 text-start input">
                                            <label class="form-label" for="category" style="color:#212B5E;">Category</label>
                                            <select id="category" name="category" class="form-control form-control-lg shadow-lg form-select" style="border-radius: 15px; padding-right: 40px; padding-left: 40px;">
                                                <option value="">Select Category</option>

                                                <?php
                                                //fetching data from the books table
                                                $ref_table = 'categories';
                                                $fetch_category = $database->getReference($ref_table)->getValue();

                                                //displaying table rows
                                                if ($fetch_category > 0) {
                                                    $num = 1;
                                                    foreach ($fetch_category as $key => $row) {
                                                        $selected = '';
                                                        $category = $row['category'];
                                                        if ($category == $book['category']) {
                                                            $selected = 'selected';
                                                        }
                                                ?>

                                                        <option value="<?php echo $category; ?>" <?php echo $selected; ?>>
                                                            <?php echo $category ?>
                                                        </option>

                                                <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                            <i class="bi bi-tag"></i>
                                        </div>
                                        <!-- Category Field end -->

                                        <!-- Publish date Field start -->
                                        <div class=" mb-3 mt-3 text-start input">
                                            <label class="form-label" for="date" style="color:#212B5E;">Publish date</label>
                                            <input type="date" id="date" name="date" class="form-control form-control-lg shadow-lg" value="<?php echo $book['date'] ?>" style="border-radius: 15px; padding-right: 40px;" />
                                            <i class="bi bi-calendar"></i>
                                        </div>
                                        <!-- Publish date Field end -->

                                        <!-- Summary Field start -->
                                        <div class=" mb-3 mt-3 text-start input">
                                            <label class="form-label" for="summary" style="color:#212B5E;">Summary</label>
                                            <textarea type="input" name="summary" rows="10" id="summary" class="form-control form-control-lg shadow-lg rows" value="<?php echo $book['summary'] ?>" style="border-radius: 15px;"></textarea>
                                        </div>
                                        <!-- Summary Field end -->

                                    </div>
                                    <!-- Form end -->

                            <?php
                                    unset($ref_table);
                                    unset($fetch_category);
                                    unset($book);
                                } else {
                                    $_SESSION['edit_book_error'] = "Book wasn't found, try again later";
                                    header('location: book_list.php');
                                    exit();
                                }
                            } else {
                                $_SESSION['edit_book_error'] = "Something went wrong, try again later";
                                header('location: book_list.php');
                                exit();
                            }

                            ?>

                            <button class="btn btn-lg btn-block text-white w-50 display-2 mb-3 " style="background-color: #212B5E; border-radius: 15px" type="update_book" name="update_book">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../includes/footer.php');
?>