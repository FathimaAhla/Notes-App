<?php

include 'components/db_connection.php';

session_start();

if (isset($_GET['delete'])) {

  $delete_id = $_GET['delete'];
  $delete_notes = $conn->prepare("DELETE FROM `notes` WHERE id = ?");
  $delete_notes->execute([$delete_id]);
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

  <main class="container mt-4 mx-auto">
    <div class="row g-5 mx-auto ">
      <div class="col-md-8 col-lg-10 mx-auto">

        <?php
        if (isset($_GET['id'])) {
          $id = $_GET['id'];
          $select_note = $conn->prepare("SELECT * FROM `notes` WHERE id = ?");
          $select_note->execute([$id]);
          if ($select_note->rowCount() > 0) {
            while ($fetch_note = $select_note->fetch(PDO::FETCH_ASSOC)) {
        ?>

              <article class="blog-post">
                <h1 class="">S<?= $fetch_note['title']; ?></h1>
                <div class="d-flex justify-content-between ">
                  <p class="blog-post-meta"><?= $fetch_note['category']; ?></p>
                  <p class="blog-post-meta">Created at: <?= $fetch_note['created_at']; ?></p>
                  <p class="blog-post-meta">Updated at: <?= $fetch_note['updated_at']; ?></p>
                  <div class="d-flex gap-2">
                    <p>
                      <a href="update_note.php?update=<?= $fetch_notes['id']; ?>" class="link-warning">Edit</a>
                    </p>
                    <p>
                      <a href="index.php?delete=<?= $fetch_notes['id']; ?>" class="link-danger" onclick="return confirm('delete this note?');">Delete</a>
                    </p>
                  </div>
                </div>
                <hr class="mt-0">
                <p><?= $fetch_note['content']; ?></p>
              </article>

        <?php
            }
          } else {
            echo '<p class="empty">no notes founded!</p>';
          }
        } 
        ?>
      </div>
    </div>

  </main>
  <?php include 'components/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>