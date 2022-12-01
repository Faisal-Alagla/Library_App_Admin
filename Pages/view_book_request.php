<?php
include('../includes/header.php');
?>

<div class="container-fluid p-0 m-0">
    <div class="my-5">
        <div class="container p-0">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                    <form class="card shadow-lg" style="border-radius: 20px" method="post"
                        action="../db/book_request_action.php" enctype="multipart/form-data">
                        <div class="card-body p-5 d-flex flex-column text-center align-items-center">
                            <h3 class="mb-5 fw-bold" style="color:#212B5E;">Requested Book Information</h3>

                            <?php
                            if (isset($_SESSION['book_request_msg'])) :
                                $msg = $_SESSION['book_request_msg'];

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
                                unset($_SESSION['book_request_msg']);
                                unset($_SESSION['book_request_flag']);
                            endif;

                            if (isset($_GET['id']) || isset($_SESSION['book_key'])) {
                                if (isset($_SESSION['book_key'])) {
                                    $book_key = $_SESSION['book_key'];
                                    unset($_SESSION['book_key']);
                                } else {
                                    $book_key = $_GET['id'];
                                }

                                $ref_table = 'book_requests';
                                $book = $database->getReference($ref_table)->getChild($book_key)->getValue();

                                if ($book > 0) {
                                    if ($book['image'] > 0) {
                                        $book_img_url = "https://firebasestorage.googleapis.com/v0/b/".$bucket_name."/o/requests_images%2F".$book['image']."?alt=media";
                                    }else{
                                        $book_img_url = "";
                                    }

                                ?>


                            <!-- Form start -->
                            <div class="mb-4 text-start w-100">

                                <input type="hidden" name="key" value="<?php echo $book_key ?>" />
                                <!-- ISBN Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="isbn" style="color:#212B5E;">ISBN</label>
                                    <input type="text" id="isbn" name="isbn"
                                        class="form-control form-control-lg shadow-lg "
                                        style="border-radius: 15px; padding-right: 40px;" minlength="10" maxlength="10"
                                        value="<?php echo $book['isbn'] ?>" required />
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                                <!-- ISBN Field end -->

                                <!-- Title Field start -->
                                <div class="input">
                                    <label class="form-label" for="title" style="color:#212B5E;">Title</label>
                                    <input type="text" id="title" name="title"
                                        class="form-control form-control-lg shadow-lg" aria-describedby="basic-addon1"
                                        style="border-radius: 15px" value="<?php echo $book['title'] ?>" required />
                                    <i class="bi bi-card-heading"></i>
                                </div>
                                <!-- Title Field end -->

                                <!-- Image Field start -->
                                <div class="col-sm-12 d-flex flex-row justify-content-center align-items-center mt-3" style="border: 1px solid #212B5E; border-radius: 15px;">
                                    <div class="input col-sm-3">
                                        <label class="form-label" for="image" style="color:#212B5E;">To edit the image, go to edit books after accepting</label>
                                        <input type="hidden" id="image" name="image"
                                            class="form-control form-control-lg shadow-lg"
                                            aria-describedby="basic-addon1" value="<?php echo $book['image'] ?>"
                                            style="border-radius: 15px"/>
                                        <!-- <i class="bi bi-card-image"></i> -->
                                    </div>
                                    <div class="col-sm-2 d-flex justify-content-center">
                                        <img src="<?php echo $book_img_url ?>"
                                            alt="No img" style="max-width: 45px;">
                                    </div>
                                </div>
                                <!-- Image Field end -->

                                <!-- Author Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="author" style="color:#212B5E;">Author</label>
                                    <input type="text" id="author" name="author"
                                        class="form-control form-control-lg shadow-lg "
                                        value="<?php echo $book['author'] ?>"
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
                                                endforeach;
                                            endif;
                                        ?>

                                    </select>
                                    <i class="bi bi-tag"></i>
                                </div>
                                <!-- Category Field end -->

                                <!-- Publish date Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="date" style="color:#212B5E;">Publish date</label>
                                    <input type="date" id="date" name="date"
                                        class="form-control form-control-lg shadow-lg"
                                        value="<?php echo $book['date'] ?>"
                                        style="border-radius: 15px; padding-right: 40px;" />
                                    <i class="bi bi-calendar"></i>
                                </div>
                                <!-- Publish date Field end -->

                                <!-- Summary Field start -->
                                <div class=" mb-3 mt-3 text-start input">
                                    <label class="form-label" for="summary" style="color:#212B5E;">Summary</label>
                                    <textarea type="input" name="summary" rows="10" id="summary"
                                        class="form-control form-control-lg shadow-lg rows"
                                        value="<?php echo $book['summary'] ?>"
                                        style="border-radius: 15px;"><?php echo $book['summary'] ?></textarea>
                                </div>
                                <!-- Summary Field end -->

                            </div>
                            <!-- Form end -->

                            <?php
                                    unset($ref_table);
                                    unset($fetch_category);
                                    unset($book);
                                } else {
                                    $_SESSION['view_request_error'] = "request wasn't found, try again later";
                                    header('location: book_requests.php');
                                    exit();
                                }
                            } else {
                                $_SESSION['view_request_error'] = "Something went wrong, try again later";
                                header('location: book_requests.php');
                                exit();
                            }

                            ?>

                            <div class="col-sm-12 row justify-content-center align-self-center">
                                <div class="col-sm-6 px-1">
                                    <button class="btn btn-lg btn-block text-white w-100 display-2 mb-3"
                                        style="background-color: #212B5E; border-radius: 15px" name="accept_request"
                                        type="accept_request">
                                        Accept
                                    </button>
                                </div>
                                <div class="col-sm-6 px-1">
                                    <button class="btn btn-lg btn-block text-white w-100 display-2 mb-3 "
                                        style="background-color: #98030e; border-radius: 15px" name="decline_request"
                                        type="decline_request">
                                        Decline
                                    </button>
                                </div>
                            </div>
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