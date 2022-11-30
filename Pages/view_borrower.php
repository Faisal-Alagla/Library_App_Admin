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

                            <?php if(isset($_GET['borrower'])) {
                                $key = $_GET['borrower'];
                                $ref_table = "students/$key";
                                $fetch_borrower = $database->getReference($ref_table)->getValue();

                                if($fetch_borrower > 0) {
                                    $first_name = $fetch_borrower['FName'];
                                    $last_name = $fetch_borrower['LName'];
                             ?>

                            <!--First name & last name of the borrower in header-->
                            <h2 class="mb-5 fw-bold" style=" color:#212B5E; "><?php echo "$first_name $last_name" ?></h2>
                            <hr class="mt-0 mb-1">

                            <!--Borrower Email-->
                            <div class=" mb-3 mt-3 text-center mx-2">
                                <h5 style="color:#212B5E; text-decoration: underline;">Email</h5>
                                <h3 style="color:#212B5E;"> <?php echo $fetch_borrower['Email'] ?> </h3>
                            </div>

                            <hr class="mt-0 mb-1">
                            <div class="pt-5 my-4 mx-2">
                                <h2 class="mb-5 fw-bold" style=" color:#212B5E; ">Borrowed Books</h2>

                                <!-- Table start -->
                                <div class="mb-4 table-responsive">
                                    <table class="table table-dark table-hover text-center align-items-center" id="paginated">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center pe-1">#</th>
                                                <th scope="col" class="text-center pe-1">ISBN</th>
                                                <th scope="col" class="text-center pe-1">Title</th>
                                                <th scope="col" class="text-center pe-1">Due-Date</th>
                                                <th scope="col" class="text-center pe-1" style="width: 10%;">Returned</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $tomorrow = strtotime('+1 days');
                                                $yesterday = strtotime('-1 days');

                                                $borrowed_books = $fetch_borrower['borrowedBooks'];
                                                $num = 1;
                                                foreach ($borrowed_books as $isbn => $due_date) {
                                                    //fetching the title of the book
                                                    $title ="";
                                                    $fetch_books = $database->getReference('books')->getValue();
                                                    if($fetch_books > 0) {
                                                        foreach($fetch_books as $row){
                                                            if($row['isbn'] == $isbn){
                                                                $title = $row['title'];
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    unset($fetch_books);
                                                        
                                                    //check borrowed books due dates
                                                    if($due_date == "pending") {
                                                        //pending is fine
                                                        $date_color = "text-success";
                                                    }else{
                                                        $date =  strtotime($due_date);
                                                        if($date >= $tomorrow) {
                                                        $date_color = "text-success";
                                                        }else if(($date > $yesterday) && ($date < $tomorrow)){
                                                            //if due-date is within 1 day
                                                            $date_color = "text-warning";
                                                        }else{
                                                            //if due-date passed without returning the book
                                                            $date_color = "text-danger";
                                                        }
                                                    }
                                                        
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $num++ ?>
                                                </td>
                                                <td>
                                                    <?php echo $isbn ?>
                                                </td>
                                                <td>
                                                    <?php echo $title ?>
                                                </td>
                                                <td>
                                                    <p class="<?php echo $date_color ?>"><?php echo $due_date ?></p>
                                                </td>
                                                <td>
                                                    <a class="btn btn-success" style="border-radius: 5px"
                                                        href="">
                                                        Returned
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
                                }else{
                                ?>

                                <!--No requests card-->
                                <div class="card shadow-lg" style=" border-radius: 20px">
                                    <div class="card-body p-5 pb-2 text-center">
                                        <h3 class="mb-5 fw-bold text-danger" style=" color:#212B5E; ">
                                            Couldn't fetch the borrower, try again later!
                                        </h3>
                                    </div>
                                </div>

                                <?php
                                }

                                unset($ref_table);
                                unset($fetch_borrower);
                                } else {
                                ?>

                                <!--No requests card-->
                                <div class="card shadow-lg" style=" border-radius: 20px">
                                    <div class="card-body p-5 pb-2 text-center">
                                        <h3 class="mb-5 fw-bold text-danger" style=" color:#212B5E; ">
                                            Something went wrong, try again later!
                                        </h3>
                                    </div>
                                </div>

                                <?php
                                }

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