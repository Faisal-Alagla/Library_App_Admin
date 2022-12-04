<?php
include('../includes/header.php');

?>

<div class="container-fluid p-0 m-0">

    <div class="my-5">
        <div class="container p-0">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                    <form class="card shadow-lg" style="border-radius: 20px" method="post"
                        action="../db/add_book_action.php" enctype="multipart/form-data">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-5 fw-bold" style="color:#212B5E;">Add New Book</h3>

                            <?php
                            //feedback message for adding a book
                            if (isset($_SESSION['book_added'])) :
                                $msg = $_SESSION['book_added'];

                                if ($_SESSION['book_added_flag']) {
                                    $msg_color = "alert-success";
                                } else {
                                    $msg_color = "alert-danger";
                                }
                            ?>

                            <div class="alert <?php echo $msg_color ?>" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                unset($_SESSION['book_added']);
                                unset($_SESSION['book_added_flag']);
                            endif;
                            ?>

                            <!-- Form start -->
                            <div class="mb-4 text-start">

                                <!-- ISBN Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="isbn" style="color:#212B5E;">ISBN</label>
                                    <input type="text" id="isbn" name="isbn"
                                        class="form-control form-control-lg shadow-lg "
                                        style="border-radius: 15px; padding-right: 40px;" minlength="10" maxlength="10"
                                        required />
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                                <!-- ISBN Field end -->

                                <!-- Title Field start -->
                                <div class="input">
                                    <label class="form-label" for="title" style="color:#212B5E;">Title</label>
                                    <input type="text" id="title" name="title"
                                        class="form-control form-control-lg shadow-lg" aria-describedby="basic-addon1"
                                        style="border-radius: 15px" required />
                                    <i class="bi bi-card-heading"></i>
                                </div>
                                <!-- Title Field end -->

                                <!-- Author Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="author" style="color:#212B5E;">Author</label>
                                    <input type="text" id="author" name="author"
                                        class="form-control form-control-lg shadow-lg "
                                        style="border-radius: 15px; padding-right: 40px;" />
                                    <i class="bi bi-vector-pen"></i>
                                </div>
                                <!-- Author Field end -->

                                <!-- Category Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="category" style="color:#212B5E;">Category</label>
                                    <select id="category" name="category"
                                        class="form-control form-control-lg shadow-lg form-select"
                                        style="border-radius: 15px; padding-right: 40px; padding-left: 40px;">
                                        <option value="">Select Category</option>

                                        <?php
                                        //fetching data from the books table
                                        $ref_table = 'categories';
                                        $fetch_category = $database->getReference($ref_table)->getValue();

                                        //displaying table rows
                                        if ($fetch_category > 0) :
                                            $num = 1;
                                            foreach ($fetch_category as $key => $row) :
                                                $category = $row['category'];
                                        ?>

                                        <option value="<?php echo $category; ?>"><?php echo $category ?></option>

                                        <?php
                                            endforeach;
                                        endif;

                                        unset($ref_table);
                                        unset($fetch_category);
                                        ?>

                                    </select>
                                    <i class="bi bi-tag"></i>
                                </div>
                                <!-- Category Field end -->

                                <!-- Image Field start -->
                                <div class="input">
                                    <label class="form-label" for="image" style="color:#212B5E;">Image</label>
                                    <input type="file" id="image" name="image"
                                        class="form-control form-control-lg shadow-lg" aria-describedby="basic-addon1"
                                        style="border-radius: 15px" />
                                    <i class="bi bi-card-image"></i>
                                </div>
                                <!-- Image Field end -->

                                <!-- Publish date Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="date" style="color:#212B5E;">Publish date</label>
                                    <input type="date" id="date" name="date"
                                        class="form-control form-control-lg shadow-lg "
                                        style="border-radius: 15px; padding-right: 40px;" />
                                    <i class="bi bi-calendar"></i>
                                </div>
                                <!-- Publish date Field end -->

                                <!-- Summary Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="summary" style="color:#212B5E;">Summary</label>
                                    <textarea type="input" name="summary" rows="10" id="summary"
                                        class="form-control form-control-lg shadow-lg rows"
                                        style="border-radius: 15px;"></textarea>
                                </div>
                                <!-- Summary Field end -->

                            </div>
                            <!-- Form end -->


                            <button class="btn btn-lg btn-block text-white w-50 display-2 mb-3 "
                                style="background-color: #212B5E; border-radius: 15px" type="add_book"
                                name="add_book">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>