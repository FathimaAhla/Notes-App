<?php

include 'components/db_connection.php';

session_start();

if (isset($_POST['update_note'])) {

  $note_id = $_POST['note_id'];
  $note_id = filter_var($note_id, FILTER_SANITIZE_STRING);
  $title = $_POST['title'];
  $title = filter_var($title, FILTER_SANITIZE_STRING);
  $content = $_POST['content'];
  $content = filter_var($content, FILTER_SANITIZE_STRING);
  $category = $_POST['category'];
  $category = filter_var($category, FILTER_SANITIZE_STRING);

  $updated_at = date('Y-m-d H:i:s');

  $update_note = $conn->prepare("UPDATE `notes` SET title = ?, content = ?, category = ?, updated_at = ? WHERE id = ?");
  $update_note->execute([$title, $content, $category, $updated_at, $note_id]);
  $message[] = 'note updated!';
  header('location:index.php');
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/1a76eb0570.js" crossorigin="anonymous"></script>
</head>

<body>
  <?php include 'components/header.php'; ?>

  <div class="container ">
    <div class="py-5 text-center ">
      <h2>Edit Note</h2>
      <p class="lead">

      </p>
    </div>

    <div class="col-md-4 col-lg-7 mx-auto">
      <?php
      $update_id = $_GET['update'];
      $select_note = $conn->prepare("SELECT * FROM `notes` WHERE id = ?");
      $select_note->execute([$update_id]);
      if ($select_note->rowCount() > 0) {
        while ($fetch_note = $select_note->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <form action="" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>

            <input type="hidden" name="note_id" value="<?= $fetch_note['id']; ?>">

            <div class="row g-3">
              <div class="col-12">
                <label for="title" class="form-label">Title</label>
                <input type="title" name="title" class="form-control" id="title" value="<?= $fetch_note['title']; ?>">
                <div class="invalid-feedback">
                  Please fill the Title
                </div>
              </div>

              <div class="col-12">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="category" required>
                  <option value="">Choose...</option>
                  <option>United States</option>
                </select>
                <div class="invalid-feedback">
                  Please select your category.
                </div>
              </div>

              <div class="col-12">
                <label for="content" class="form-label">Content</label>
                <textarea type="content" name="content" class="form-control" id="content" style="height: 200px"> <?= $fetch_note['content']; ?>" </textarea>
                <div class="invalid-feedback">
                  Please Enter your content
                </div>
              </div>
            </div>

            <button class="w-100 btn btn-primary btn-lg mt-4" type="submit" name="update_note">Update Note</button>

            <hr class="mt-4">
            <div class="text-center">
              <a href="index.php" class="btn btn-link ">Go Back</a>
            </div>



          </form>
      <?php
        }
      }
      ?>
    </div>
  </div>

  <?php include 'components/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>