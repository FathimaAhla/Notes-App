<?php
include 'components/db_connection.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
  header('location:login.php');
};

if (isset($_POST['create_note'])) {
  $title = $_POST['title'];
  $title = filter_var($title, FILTER_SANITIZE_STRING);
  $content = $_POST['content'];
  $content = filter_var($content, FILTER_SANITIZE_STRING);
  $category = $_POST['category'];
  $category = filter_var($category, FILTER_SANITIZE_STRING);
  $created_at = date('Y-m-d H:i:s'); 
  $select_note = $conn->prepare("SELECT * FROM `notes` WHERE title = ?");
  $select_note->execute([$title]);
  $insert_note = $conn->prepare("INSERT INTO `notes`(title,content,category,created_at) VALUES(?,?,?,?)");
  $insert_note->execute([$title, $content, $category, $created_at]);
  
  $message_success[] = 'Note created successfully';
  header('location:index.php');
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
  <script src="https://kit.fontawesome.com/1a76eb0570.js" crossorigin="anonymous"></script>
</head>
<body>
  <?php include 'components/header.php'; ?>
  <div class="container ">
    <div class="py-5 text-center ">
      <h2>Create Note</h2>
      <p class="lead">
      </p>
    </div>
    <div class="col-md-4 col-lg-7 mx-auto">
      <form action="" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
        <div class="row g-3">
          <div class="col-12">
            <label for="title" class="form-label">Title</label>
            <input type="title" class="form-control" id="title" name="title">
            <div class="invalid-feedback">
              Please fill the Title
            </div>
          </div>
          <div class="col-12">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" name="category" id="category" required>
              <option value="">Choose...</option>
              <option value="1">United States</option>
            </select>
            <div class="invalid-feedback">
              Please select your category.
            </div>
          </div>

          <div class="col-12">
            <label for="content" class="form-label">Content</label>
            <textarea  class="form-control" name="content" id="tiny" > </textarea>
            <div class="invalid-feedback">
              Please Enter your content
            </div>
          </div>
          
        </div>

        <button class="w-100 btn btn-primary btn-lg mt-4" type="submit" name="create_note">Create Note</button>
        <hr class="mt-4">
        <div class="text-center">
          <a href="index.php" class="btn btn-link ">Go Back</a>
        </div>


      </form>
    </div>
  </div>
  <?php include 'components/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>