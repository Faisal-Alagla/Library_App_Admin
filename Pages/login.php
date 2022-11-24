<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css " rel="stylesheet "
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi " crossorigin="anonymous " />
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <title>Login</title>
    <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <style>
    body {
        font-family: 'Cairo';
        font-weight: bold;
    }

    .input input {
        padding-left: 40px;
    }

    .input {
        position: relative;
    }

    .input img {
        position: absolute;
        left: 0;
        top: 38px;
        padding: 9px 8px;
    }
    </style>
</head>

<body>
    <div class="container-fluid p-2 m-0">

        <!-- Logo -->
        <div class="d-flex justify-content-center align-items-center">
            <img class="py-5" style="height: 10vw;" src="../images/Pocket_Lib_Logo.png" alt=" " />
        </div>

        <div class="py-5">
            <div class="container p-0">
                <div class="row d-flex justify-content-center align-items-center h-100 p-0">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <form class="card shadow-lg" style="border-radius: 20px" method="post"
                            action="../db/login_action.php">
                            <div class="card-body p-5 text-center">
                                <h3 class="mb-5 fw-bold" style="color:#212B5E;">Login</h3>

                                <!-- Form start -->
                                <div class="mb-4 text-start">
                                    <div class="input">
                                        <!-- user/email field start -->
                                        <label class="form-label" for="email" style="color:#212B5E;">Email</label>
                                        <input type="text" id="email" name="email"
                                            class="form-control form-control-lg shadow-lg"
                                            aria-describedby="basic-addon1" style="border-radius: 15px" />
                                        <img src="../images/User_icon.png" alt="">
                                    </div>
                                    <!-- user/email field end -->

                                    <!-- Password field start -->
                                    <div class=" mb-3 mt-3 text-start input">
                                        <label class="form-label" for="password" style="color:#212B5E;">Password</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg shadow-lg "
                                            style="border-radius: 15px; padding-right: 40px;" />
                                        <img src="../images/Lock_icon.png" alt="">
                                    </div>
                                    <!-- Password field end -->

                                </div>
                                <!-- Form end -->

                                <?php
                                if (isset($_SESSION['invalid_login'])) {
                                    $msg =  $_SESSION['invalid_login'];
                                ?>

                                <p class="text-danger"><?php echo $msg; ?></p>

                                <?php
                                }
                                unset($_SESSION['invalid_login']);
                                ?>

                                <button class="btn btn-lg btn-block text-white w-50 display-2 mb-3 "
                                    style="background-color: #212B5E; border-radius: 15px" type="login"
                                    name="login">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>