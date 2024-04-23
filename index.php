<?php
include 'components/db_connection.php';

session_start();

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_notes = $conn->prepare("DELETE FROM `notes` WHERE id = ?");
    $delete_notes->execute([$delete_id]);
}

$records_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;
$select_notes = $conn->prepare("SELECT * FROM `notes` LIMIT :offset, :records_per_page");


$select_notes->bindParam(':offset', $offset, PDO::PARAM_INT);
$select_notes->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$select_notes->execute();

$total_records = $conn->query("SELECT COUNT(*) FROM `notes`")->fetchColumn();

$total_pages = ceil($total_records / $records_per_page);
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

    <!-- Table  -->
    <div class="container">
        <div class="d-flex justify-content-between mt-4">
            <h2 class="">Notes</h2>
        </div>
        <!-- sort by button  -->
        <div class="d-flex flex-row-reverse">
            <div class=" dropdown mb-2 ">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Sort By
                </button>
                <ul class="dropdown-menu" data-bs-theme="light">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another</a></li>
                    <li><a class="dropdown-item" href="#">Something</a></li>
                </ul>
            </div>
        </div>
        <!-- sort by button end  -->

        <table class="table table-bordered table-striped rounded-2">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Created</th>
                    <th scope="col">Updated</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($select_notes->rowCount() > 0) {
                    while ($fetch_notes = $select_notes->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <tr>
                            <th scope="row"><?= $fetch_notes['id']; ?></th>
                            <td><?= $fetch_notes['title']; ?></td>
                            <td><?= $fetch_notes['category']; ?></td>
                            <td><?= $fetch_notes['created_at']; ?></td>
                            <td>@<?= $fetch_notes['updated_at']; ?></td>
                            <td>
                                <a href="show_note.php?id=<?= $fetch_notes['id']; ?>" class="btn btn-outline-success">Show</a>
                                <a href="update_note.php?update=<?= $fetch_notes['id']; ?>" class="btn btn-outline-warning">Edit</a>
                                <a href="index.php?delete=<?= $fetch_notes['id']; ?>" class="btn btn-outline-danger" onclick="return confirm('delete this note?');">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    echo '<p class="">No notes found!</p>';
                }
                ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php
                    if ($current_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                    }

                    for ($i = 1; $i <= $total_pages; $i++) {
                        if ($i == $current_page) {
                            echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                        }
                    }

                    if ($current_page < $total_pages) {
                        echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>