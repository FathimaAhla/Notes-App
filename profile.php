<?php
include 'components/db_connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header('location:login.php');
};

?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notes App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="css/style.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/1a76eb0570.js" crossorigin="anonymous"></script>

</head>

<body>
  <?php include 'components/header.php'; ?>

  <div class="container py-5">

    <?php
    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
    $select_profile->execute([$user_id]);
    if ($select_profile->rowCount() > 0) {
      $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    ?>


      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Full Name</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?= $fetch_profile['first_name'] ;?> <?= $fetch_profile['last_name'] ;?><p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Email</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"><?= $fetch_profile['email'] ;?></p>
                </div>
              </div>

              <hr>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0"></p>
                </div>
                <div class="col-sm-9">
                  <a type="button" href="update_profile.php" class="btn btn-outline-warning">Edit Profile</a>
                  <!-- <button type="button" class="btn btn-outline-danger">Delete Profile</button> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    <?php
    }
    ?>
  </div>



  <?php include 'components/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>