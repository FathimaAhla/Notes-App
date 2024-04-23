<?php
include 'components/db_connection.php';


session_start();


if (isset($_POST['login-submit'])) {

  $email = $_POST['email'];
  $email = filter_var($email, FILTER_SANITIZE_STRING);

  $password = sha1($_POST['password']);
  $password = filter_var($password, FILTER_SANITIZE_STRING);

  $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");

  $select_user->execute([$email, $password]);
  $row = $select_user->fetch(PDO::FETCH_ASSOC);

  if ($select_user->rowCount() > 0) {
    $_SESSION['user_id'] = $row['id'];

    header('location:index.php');
  } else {
    $message_error[] = "Incorrect username or password";
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
      <h2>Login</h2>
      <p class="lead">
        Fill out the form below to login.
      </p>
    </div>

    <div class="col-md-4 col-lg-4 mx-auto">
      <form class="needs-validation" novalidate method="post">
        <div class="row g-3">

          <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="you@example.com" name="email">
            <div class="invalid-feedback">
              Please enter a valid email address
            </div>
          </div>

          <div class="col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
            <div class="invalid-feedback">
              Invalid password
            </div>
          </div>
        </div>

        <button class="w-100 btn btn-primary btn-lg mt-4" type="submit" name="login-submit">Login</button>
        <hr class="mt-4">
        <div class="text-center">
          <a href="register.php" class="btn btn-success ">Create new account?</a>
        </div>

      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>