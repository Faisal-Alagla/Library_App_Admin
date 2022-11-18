<?php
include('../includes/header.php');

?>
<div class="container-fluid">
  <!--Welcome Messsage start-->
  <div class="d-flex justify-content-center align-items-center" style="height: 10vw">
    <h1 class="text-light fw-bold">Welcome, <?php echo $_SESSION['user'] ?>!</h1>
  </div>
  <!--Welcome Messsage end-->

  <!--horizontal line-->
  <div class="d-flex justify-content-center align-items-center" style="height: 5vw">
    <hr class="text-light w-50" />
  </div>

  <!--Book requests card start-->
  <div class="d-flex justify-content-center">
    <div class="card bg-dark w-75" style="border-radius: 20px">
      <div class="card-body d-flex justify-content-center">
        <div class="col-sm-5 text-center">
          <h3 class="text-light">Book Requests</h3>
        </div>
        <div class="col-sm-2 text-center">
          <p class="text-light mx-2">|</p>
        </div>
        <div class="col-sm-5 text-center">
          <h3 class="text-light">366</h3>
        </div>
      </div>
    </div>
  </div>
  <!--Book requests card end-->

  <!--horizontal line-->
  <div class="d-flex justify-content-center align-items-center" style="height: 5vw">
    <hr class="text-light w-50" />
  </div>

  <!--Current Announcement card start-->
  <div class="d-flex justify-content-center">
    <div class="card bg-dark w-75" style="border-radius: 20px">
      <div class="card-body d-flex flex-column justify-content-center">
        <div class="text-center">
          <h3 class="text-light">Current Announcement</h3>
        </div>
        <div class="d-flex justify-content-center align-items-center" style="height: 2vw">
          <hr class="text-light w-50" />
        </div>
        <div class="bg-secondary" style="border-radius: 5px">
          <p class="m-2" style="font-size: 20px;">

            <?php
                echo $_SESSION['announcement'];
            ?>

          </p>
        </div>
      </div>
    </div>
  </div>
  <!--Current Announcement card end-->
</div>

<?php
include('../includes/footer.php');
?>