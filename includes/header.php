<?php
session_start();
include("../db/config.php");
$cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
$active = "active";

if (($cur_page == "add_book.php") || ($cur_page == "book_list.php") || ($cur_page == "edit_book.php") || ($cur_page == "post_announcement.php")) {
  $actions_active = $active;
} else {
  $actions_active = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css " rel="stylesheet " integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi " crossorigin="anonymous " />
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <title>Library Admin</title>
  <link href='https://fonts.googleapis.com/css?family=Cairo' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body style="background-color: #1b1b1b">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand px-3" href="#">Admin Panel</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item px-2">
            <a class="nav-link <?php if ($cur_page == 'home.php') echo $active; ?>" aria-current="page" href="home.php">Home</a>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link <?php if ($cur_page == 'borrowers.php') echo $active; ?>" href="#">Borrowers</a>
          </li>
          <li class="nav-item dropdown px-2">
            <a class="nav-link dropdown-toggle <?php echo $actions_active ?> " href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Actions
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">

              <?php
              $ref_table = "announcements";
              $fetch_announcement = $database->getReference($ref_table)->getValue();
              if($fetch_announcement > 0){
                $_SESSION['announcement_exists'] = true;
              }else{
                $_SESSION['announcement_exists'] = false;
              }
              
              if ($_SESSION['announcement_exists']) {
                $announcement_action = "Update";
              } else {
                $announcement_action = "Post";
              } ?>

              <li><a class="dropdown-item" href="post_announcement.php"><?php echo $announcement_action ?> Announcement</a></li>
              <li><a class="dropdown-item" href="add_book.php">Add book</a></li>
              <li><a class="dropdown-item" href="book_list.php">Edit books</a></li>
              <!-- <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="#">Something else here</a></li> -->
            </ul>
          </li>
          <li class="nav-item px-2">
            <a class="nav-link  <?php if ($cur_page == 'book_requests.php') echo $active; ?>" href="#" tabindex="-1" aria-disabled="true">Book Requests</a>
          </li>
        </ul>
        <div class="d-flex flex-row">
          <form class="d-flex mx-2" method="post" action="#">
            <button class="btn btn-outline-light" type="logout" name="logout">Profile</button>
          </form>
          <form class="d-flex mx-2" method="post" action="../db/logout_action.php">
            <button class="btn btn-outline-light" type="logout" name="logout">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </nav>