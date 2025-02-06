<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$insert = false;
$update = false;
$delete = false;

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM notes WHERE sno = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $sno);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $sql = "UPDATE notes SET title = ?, description = ? WHERE sno = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $sno);
        $result = mysqli_stmt_execute($stmt);
        $update = $result ? true : false;
        mysqli_stmt_close($stmt);
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = "INSERT INTO notes (title, description, tstamp) VALUES (?, ?, current_timestamp())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $title, $description);
        $result = mysqli_stmt_execute($stmt);
        $insert = $result ? true : false;
        mysqli_stmt_close($stmt);
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <title>CRUD Application</title>
</head>

<body>
    <div class="container my-4">
        <h2>Add a Note</h2>
        <form action="/crud/index.php" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th>S.NO</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM notes";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>" . $row['sno'] . "</td>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>
                            <button class='edit btn btn-sm btn-primary' data-id='" . $row['sno'] . "'>Edit</button>
                            <button class='delete btn btn-sm btn-danger' data-id='" . $row['sno'] . "'>Delete</button>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/crud/index.php" method="post">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="form-group">
                            <label for="titleEdit">Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit">
                        </div>
                        <div class="form-group">
                            <label for="descriptionEdit">Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();

            $('.delete').click(function () {
                let id = $(this).data('id');
                if (confirm("Are you sure you want to delete this note?")) {
                    window.location = `/crud/index.php?delete=${id}`;
                }
            });

            $('.edit').click(function () {
                let id = $(this).data('id');
                let row = $(this).closest('tr');
                let title = row.find('td:eq(1)').text();
                let description = row.find('td:eq(2)').text();

                $('#titleEdit').val(title);
                $('#descriptionEdit').val(description);
                $('#snoEdit').val(id);
                $('#editModal').modal('show');
            });
        });
    </script>
</body>

</html>
