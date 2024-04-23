<?php
include 'components/db_connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
};

if (isset($_POST['register-submit'])) {

  $first_name = $_POST['first_name'];
  $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);

  $last_name = $_POST['last_name'];
  $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);

  $password = sha1($_POST['password']);
  $password = filter_var($password, FILTER_SANITIZE_STRING);

  $confirm_password = sha1($_POST['confirm_password']);
  $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);

  $select_user = $conn->prepare("SELECT * FROM `users` WHERE email  = ?");
  $select_user->execute([$email]);
  $row = $select_user->fetch(PDO::FETCH_ASSOC);

  if ($select_user->rowCount() > 0) {
    $message_error[] = "Email already taken";
  } else {
    if ($password != $confirm_password) {
      $message_error = "confirm password not match";
    } else {
      $insert_user = $conn->prepare("INSERT INTO `users` (first_name,last_name,email,password) VALUES (?,?,?,?)");
      $insert_user->execute([$first_name, $last_name, $email, $confirm_password]);
      $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? ");
      $select_user->execute([$email, $confirm_password]);
      $row = $select_user->fetch(PDO::FETCH_ASSOC);
      if ($select_user->rowCount() > 0) {
        $_SESSION[`user_id`] = $row[`id`];
        $message_success[] = "Account Created Successfully";
        header('Location:index.php');
      }
    }
  }
}
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
  <div class="container ">
    <div class="py-5 text-center ">
      <h2>Create account</h2>
      <p class="lead">
        Fill out the form below to create an account.
      </p>
    </div>

    <div class="col-md-4 col-lg-5 mx-auto">
      <form class="needs-validation" novalidate method="post">
        <div class="row g-3">
          <div class="col-sm-6">
            <label for="first_name" class="form-label">First name</label>
            <input type="text" class="form-control" id="first_name" placeholder="" value="" name="first_name" required>
            <div class="invalid-feedback">
              first name is required.
            </div>
          </div>

          <div class="col-sm-6">
            <label for="last_name" class="form-label">Last name</label>
            <input type="text" class="form-control" id="last_name" placeholder="" value="" name="last_name" required>
            <div class="invalid-feedback">
              last name is required.
            </div>
          </div>


          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="you@example.com" name="email" required>
            <div class="invalid-feedback">
              Please enter a valid email.
            </div>
          </div>

          <div class="col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
            <div class="invalid-feedback">
              Please enter your password.
            </div>
          </div>

          <div class="col-12">
            <label for="confirm_password" class="form-label">Retype your Password</label>
            <input type="password" class="form-control" id="confirm_password" placeholder="Retype your password" name="confirm_password">
            <div class="invalid-feedback">
              Please retype your password.
            </div>
          </div>

        </div>


        <button class="w-100 btn btn-primary btn-lg mt-4" type="submit" name="register-submit">Create Account</button>
        <hr class="mt-4">
        <div class="text-center">
          <a href="login.php" class="btn btn-link ">Already have account?</a>
        </div>



      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>