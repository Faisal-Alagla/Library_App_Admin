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
                                    <form class="col-sm-12 d-flex flex-row justify-content-center align-items-center mb-3" method="post" action="../db/manage_categories_action.php">
                                        <input type="hidden" name="key" value="<?php echo $category_key ?>" />
                                        <div class="col-sm-4 d-flex flex-row justify-content-evenly align-items-center input text-start">
                                            <label class="form-label mb-0" for="label" style="color:#212B5E;">Label</label>
                                            <input type="text" id="label" name="label" class="form-control form-control-lg shadow-lg w-75" aria-describedby="basic-addon1" value="<?php echo $category['label'] ?>" style="border-radius: 15px; padding-left: 5px; padding-right: 5px;" required/>
                                        </div>
                                        <div class="col-sm-4 d-flex flex-row justify-content-evenly align-items-center input text-start">
                                            <label class="form-label mb-0" for="value" style="color:#212B5E;">Value</label>
                                            <input type="text" id="value" name="value" class="form-control form-control-lg shadow-lg w-75" aria-describedby="basic-addon1" value="<?php echo $category['value'] ?>" style="border-radius: 15px; padding-left: 5px; padding-right: 5px;" required />
                                        </div>
                                        <div class="col-sm-4 d-flex flex-row justify-content-evenly align-items-center">
                                            <button class="btn btn-lg btn-block text-white display-2 w-75" style="background-color: #212B5E; border-radius: 15px" type="update_category" name="update_category">Update</button>
                                        </div>
                                    </form>
                                    <!-- Edit Category Field end -->

                                <?php
                                } else {
                                ?>

                                    <p class="mx-5 text-danger">
                                        Something went wrong, try again later!
                                    </p>

                                <?php
                                }
                            }

                            //message after category update
                            if (isset($_SESSION['cateogry_updated'])) {
                                $msg = $_SESSION['cateogry_updated'];

                                //message color changes wether update is successful or failed
                                if ($_SESSION['cateogry_updated_flag']) {
                                    $msg_color = "text-success";
                                } else {
                                    $msg_color = "text-danger";
                                }

                                ?>

                                <p class="mx-5 <?php echo $msg_color ?> ">
                                    <?php echo $msg; ?>
                                </p>

                            <?php
                                //clearing session variables
                                unset($_SESSION['cateogry_updated']);
                                unset($_SESSION['cateogry_updated_flag']);
                            }

                            //message after category deletion
                            if (isset($_SESSION['cateogry_deleted'])) {
                                $msg = $_SESSION['cateogry_deleted'];
                                if($_SESSION['cateogry_deleted_flag']){
                                    $msg_color = "text-success";
                                }else{
                                    $msg_color = "text-danger";
                                }

                            ?>

                                <p class="mx-5 <?php echo $msg_color ?> ">
                                    <?php echo $msg; ?>
                                </p>

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
                                                <th scope="col">Label</th>
                                                <th scope="col">Value</th>
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
                                                        <td>
                                                            <?php echo $row['label'] ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['value'] ?>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-sm text-white w-100" style="background-color: #3e51b1; border-radius: 5px" href="manage_categories.php?id=<?php echo $key ?>">
                                                                Edit
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-sm text-white w-100" style="background-color: #98030e; border-radius: 5px" href="../db/manage_categories_action.php?id=<?php echo $key ?>">
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
                        </div>
                        <!--end of card-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="container-fluid">
    <div class="d-flex justify-content-center align-items-center" style="height: 40vw;">
        <img src="../images/page_construction.jpg" alt="">
    </div>
</div> -->

<?php
include('../includes/footer.php');
?>