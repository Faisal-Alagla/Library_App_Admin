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

                            <div class="mb-4 mx-2">

                                <?php
                                //fetching data from the requests table
                                $ref_table = 'students';
                                $fetch_students = $database->getReference($ref_table)->getValue();

                                //displaying requests table, if exists any
                                if ($fetch_students > 0) {
                                    $num = 1;
                                ?>

                                <!-- Table start -->
                                <div class="mb-4 table-responsive">
                                    <table class="table table-dark table-hover text-center align-items-center" id="paginated">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center pe-1">#</th>
                                                <th scope="col" class="text-center pe-1">Fname</th>
                                                <th scope="col" class="text-center pe-1">Lname</th>
                                                <th scope="col" class="text-center pe-1">Email</th>
                                                <th scope="col" class="text-center pe-1">Status</th>
                                                <th scope="col" class="text-center pe-1" style="width: 10%;">View</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                                $tomorrow = strtotime('+1 days');
                                                $yesterday = strtotime('-1 days');

                                                foreach ($fetch_students as $key => $row) {
                                                    if (isset($row['borrowedBooks'])){
                                                        //if user has borrowed books -> check due-dates
                                                        $status_color = "text-success";
                                                        $status_text = "Fine";
                                                        foreach ($row['borrowedBooks'] as $due_date) {
                                                            if($due_date == "pending") {
                                                                //pending is fine
                                                                continue;
                                                            }else{
                                                                $due_date =  strtotime($due_date);
                                                                if($due_date >= $tomorrow) {
                                                                    //fine
                                                                    continue;
                                                                }else if(($due_date > $yesterday) && ($due_date < $tomorrow)){
                                                                    //if due-date is within 1 day
                                                                    $status_color = "text-warning";
                                                                    $status_text = "Has close due-dates";
                                                                }else{
                                                                    //if due-date passed without returning the book
                                                                    $status_color = "text-danger";
                                                                    $status_text = "Has past-dues";
                                                                    break;
                                                                }
                                                            }
                                                        }
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $num++ ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['FName'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['LName'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $row['Email'] ?>
                                                </td>
                                                <td>
                                                    <p class="<?php echo $status_color ?>"><?php echo $status_text ?></p>
                                                </td>
                                                <td>
                                                    <a class="btn btn-sm btn-success w-100" style="border-radius: 5px"
                                                        href="view_borrower.php?id=<?php echo $key ?>">
                                                        View
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

                                <?php
                                } else {
                                ?>

                                <!--No requests card-->
                                <div class="card shadow-lg" style=" border-radius: 20px">
                                    <div class="card-body p-5 pb-2 text-center">
                                        <h3 class="mb-5 fw-bold text-success" style=" color:#212B5E; ">
                                            There are currently no borrowers
                                        </h3>
                                    </div>
                                </div>

                                <?php
                                }

                                unset($ref_table);
                                unset($fetch_students);
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