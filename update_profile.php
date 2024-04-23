<?php
include 'components/db_connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    //   header('location:login.php');

};

if (isset($_POST['updateInfo'])) {

    $first_name = $_POST['first_name'];
    $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);

    $last_name = $_POST['last_name'];
    $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);



    if (!empty($first_name)) {
        $update_name = $conn->prepare("UPDATE `users` SET first_name = ? WHERE id = ?");
        $update_name->execute([$first_name, $user_id]);
    }
    if (!empty($last_name)) {
        $update_name = $conn->prepare("UPDATE `users` SET last_name = ? WHERE id = ?");
        $update_name->execute([$last_name, $user_id]);
    }
    if (!empty($email)) {
        $select_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
        $select_email->execute([$email, $user_id]);
        if ($select_email->rowCount() > 0) {
            $message_error[] = 'Email already exists';
        } else {
            $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
        }
    }
}

// Update Password function 
if (isset($_POST['updatePassword'])) {

    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];

    $old_password = sha1($_POST['oldPassword']);
    $old_password = filter_var($old_password, FILTER_SANITIZE_STRING);

    $password = sha1($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);

    $confirm_password = sha1($_POST['confirm_password']);
    $confirm_password = filter_var($confirm_password, FILTER_SANITIZE_STRING);

    if ($old_password != $empty_pass) {
        if ($old_password != $prev_pass) {
            $message_error[] = 'old password not matched!';
        } elseif ($password != $confirm_password) {
            $message_error[] = 'confirm password not matched!';
        } else {
            if ($password != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass->execute([$confirm_password, $user_id]);
                $message_success[] = 'Password updated successfully!';
            } else {
                $message_error[] = 'please enter a new password!';
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

    <?php include 'components/header.php'; ?>
    <div class="container ">
        <div class="py-5 text-center ">
            <h2>Update account</h2>
            <p class="lead">
                Fill out the form below to update your details.
            </p>
        </div>

        <div class="col-md-4 col-lg-5 mx-auto">

            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <form class="needs-validation" novalidate method="post" action="">
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

                        <button class="w-100 btn btn-secondary btn-lg mt-4" type="submit" name="updateInfo">Update Account</button>

                </form>
            <?php
            }
            ?>
            <hr class="mt-4">

            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <form class="needs-validation" novalidate method="post" action="">
                <div class="col-12">
                        <label for="oldPassword" class="form-label">Old Password</label>
                        <input type="password" class="form-control" id="oldPassword" placeholder="oldPassword" name="oldPassword" required>
                        <div class="invalid-feedback">
                            Please enter your old Password.
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


        <button class="w-100 btn btn-secondary btn-lg mt-4" type="submit" name="updatePassword">Update Password</button>
        <hr class="mt-4">
        <div class="text-center">
            <a href="profile.php" class="btn btn-link ">Go Back</a>
        </div>



        </form>

    <?php
            }
    ?>
    </div>
    </div>
    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>