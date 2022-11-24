<?php
include('../includes/header.php');

?>

<div class="row container-fluid p-0 m-0">
    <div class="col-sm-12 p-0 my-5">
        <div class="container p-0 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                <div class="col-sm-12 col-md-11 col-lg-10 col-xl-9">
                    <div class="card shadow-lg" style=" border-radius: 20px">
                        <!--start of card-->
                        <div class="card-body p-5 pb-2 text-center">

                            <h3 class="mb-5 fw-bold" style=" color:#212B5E; ">Add a Category</h3>

                            <?php
                            if (isset($_SESSION['category_added'])) {
                                $msg = $_SESSION['category_added'];

                                if ($_SESSION['category_added_flag']) {
                                    $msg_color = "alert-success";
                                } else {
                                    $msg_color = "alert-danger";
                                }

                            ?>

                            <div class="alert <?php echo $msg_color ?>" role="alert">
                                <?php echo $msg ?>
                            </div>

                            <?php
                                unset($_SESSION['category_added']);
                                unset($_SESSION['category_added_flag']);
                            }
                            ?>

                            <!-- Add Category Field start -->
                            <form class="col-sm-12 d-flex flex-row justify-content-center align-items-center mb-3"
                                method="post" action="../db/manage_categories_action.php">
                                <div
                                    class="col-sm-4 d-flex flex-row justify-content-evenly align-items-center input text-start">
                                    <!-- <label class="form-label" for="category" style="color:#212B5E;">Category</label> -->
                                    <input type="text" id="category" name="category"
                                        class="form-control form-control-lg shadow-lg w-75"
                                        aria-describedby="basic-addon1" value=""
                                        style="border-radius: 15px; padding-left: 5px; padding-right: 5px;" required />
                                </div>
                                <!-- <div class="col-sm-4 d-flex flex-row justify-content-evenly align-items-center input text-start">
                                    <label class="form-label mb-0" for="value" style="color:#212B5E;">Value</label>
                                    <input type="text" id="value" name="value" class="form-control form-control-lg shadow-lg w-75" aria-describedby="basic-addon1" value="" style="border-radius: 15px; padding-left: 5px; padding-right: 5px;" required />
                                </div> -->
                                <div class="col-sm-4 d-flex flex-row justify-content-evenly align-items-center">
                                    <button class="btn btn-lg btn-block text-white display-2 w-100 ms-2"
                                        style="background-color: #212B5E; border-radius: 15px" type="add_category"
                                        name="add_category">Add</button>
                                </div>
                            </form>
                            <!-- Add Category Field end -->

                            <!--horizontal line-->
                            <div class="d-flex justify-content-center align-items-center" style="height: 5vw">
                                <hr class="w-50" style="border: 2px solid #212B5E; border-radius: 4px;" />
                            </div>

                            <h3 class="mb-5 fw-bold" style=" color:#212B5E; ">Manage Categories</h3>

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
                            if (isset($_GET['id'])) {
                                $category_key = $_GET['id'];

                                $ref_table = 'categories';
                                $category = $database->getReference($ref_table)->getChild($category_key)->getValue();

                                if ($category > 0) {
                            ?>

                            <!-- Edit Category Field start -->
                            <form class="col-sm-12 d-flex flex-row justify-content-center align-items-center mb-3"
                                method="post" action="../db/manage_categories_action.php">
                                <input type="hidden" name="key" value="<?php echo $category_key ?>" />
                                <div
                                    class="col-sm-5 d-flex flex-column justify-content-center align-items-center input text-start mx-1">
                                    <label class="form-label mb-1 align-self-start fw-bold" for="category"
                                        style="color:#212B5E;">Update Category</label>
                                    <input type="text" id="category" name="category"
                                        class="form-control form-control-lg shadow-lg" aria-describedby="basic-addon1"
                                        value="<?php echo $category['category'] ?>"
                                        style="border-radius: 15px; padding-left: 5px; padding-right: 5px;" required />
                                </div>
                                <!-- <div class="col-sm-4 d-flex flex-row justify-content-evenly align-items-center input text-start">
                                            <label class="form-label mb-0" for="value" style="color:#212B5E;">Value</label>
                                            <input type="text" id="value" name="value" class="form-control form-control-lg shadow-lg w-75" aria-describedby="basic-addon1" value="<?php //echo $category['value'] ?>" style="border-radius: 15px; padding-left: 5px; padding-right: 5px;" required />
                                        </div> -->
                                <div
                                    class="col-sm-3 d-flex flex-row justify-content-center align-items-center align-self-end mx-1">
                                    <button class="btn btn-lg btn-block text-white display-2 w-100"
                                        style="background-color: #212B5E; border-radius: 15px" type="update_category"
                                        name="update_category">Update</button>
                                </div>
                                <div
                                    class="col-sm-3 d-flex flex-row justify-content-center align-items-center align-self-end mx-1">
                                    <a class="btn btn-lg btn-block text-white display-2 w-100"
                                        style="background-color: #98030e; border-radius: 15px"
                                        href="manage_categories.php">Cancel</a>
                                </div>
                            </form>
                            <!-- Edit Category Field end -->

                            <?php

                                } else {
                                ?>

                            <div class="alert mx-5 alert-danger" role="alert">
                                Something went wrong, try again later!
                            </div>

                            <?php
                                }
                                unset($category_key);
                                unset($ref_table);
                                unset($category);
                            }

                            //message after category update
                            if (isset($_SESSION['cateogry_updated'])) {
                                $msg = $_SESSION['cateogry_updated'];

                                //message color changes wether update is successful or failed
                                if ($_SESSION['cateogry_updated_flag']) {
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
                                unset($_SESSION['cateogry_updated']);
                                unset($_SESSION['cateogry_updated_flag']);
                            }

                            //message after category deletion
                            if (isset($_SESSION['cateogry_deleted'])) {
                                $msg = $_SESSION['cateogry_deleted'];
                                if ($_SESSION['cateogry_deleted_flag']) {
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
                                unset($_SESSION['cateogry_deleted']);
                                unset($_SESSION['cateogry_deleted_flag']);
                            }
                            ?>

                            <div class="mb-4 mx-2">
                                <!-- Table start -->
                                <div class="mb-4 table-responsive">
                                    <table class="table table-dark table-hover text-center align-items-center">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Category</th>
                                                <!-- <th scope="col">Value</th> -->
                                                <th scope="col" style="width: 7%;">Edit</th>
                                                <th scope="col" style="width: 7%;">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            //fetching data from the books table
                                            $ref_table = 'categories';
                                            $fetch_categories = $database->getReference($ref_table)->getValue();

                                            //displaying table rows
                                            if ($fetch_categories > 0) {
                                                $num = 1;
                                                foreach ($fetch_categories as $key => $row) {
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $num++ ?>
                                                </td>
                                                <!-- <td>
                                                            <?php //echo $row['label'] ?>
                                                        </td> -->
                                                <td>
                                                    <?php echo $row['category'] ?>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm text-white w-100"
                                                        style="background-color: #3e51b1; border-radius: 5px"
                                                        href="manage_categories.php?id=<?php echo $key ?>">
                                                        Edit
                                                    </a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm text-white w-100"
                                                        style="background-color: #98030e; border-radius: 5px"
                                                        data-bs-toggle="modal" data-bs-target="#<?php echo $key ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="<?php echo $key ?>" tabindex="-1"
                                                aria-labelledby="ModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-center">
                                                            <h3 class="modal-title fw-bold text-danger text-center"
                                                                id="ModalLabel">WARNING!</h3>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>Deleting this category will delete the category
                                                                attribute of <span class="text-danger fw-bold">ALL
                                                                    BOOKs</span> that are categorized as <span
                                                                    class="fw-bold"><?php echo '"' . $row['category'] . '"'; ?></span>
                                                            </h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Abort</button>
                                                            <a type="button" class="btn text-light"
                                                                style="background-color: #98030e; border-radius: 5px"
                                                                href="../db/manage_categories_action.php?delete_id=<?php echo $key ?>">Delete
                                                                anyway</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                                }
                                            }
                                            unset($ref_table);
                                            unset($fetch_categories);
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