<?php
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'buy bookd', 'plsees buy book from store', current_timestamp());


$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
$insert =false;
$update = false;
$delete = false;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully";

if (isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM notes WHERE sno = '$sno'";
  $result = mysqli_query($conn, $sql);
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
  if(isset($_POST['snoEdit'])){
    // appdate the recode 
    $sno = $_POST['snoEdit'];
    $title = $_POST["titleEdit"];
    $description = $_POST["descriptionEdit"];

    $sql = "UPDATE `notes` SET `title` = '$title' , `description` = '$description' WHERE `notes`.`sno` = $sno ";
  $result =mysqli_query($conn, $sql);

  if($result){
    if($result){
      $update =true;
    }
  }
  }

  else{

  
  $title = $_POST["title"];
  $description = $_POST["description"];

  $sql = "INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$description', current_timestamp())";
  $result =mysqli_query($conn, $sql);

 if($result){
  // echo "Note Added Successfully";
  $insert =true;
 }
 else{
  echo "Note Not Added";
 }

}
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

  <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>



  <title>crud </title>
</head>

<body>
  <!-- Edit  modal -->
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit modal
</button> -->

  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit note this note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/crud/index.php" method="post">
            <input type="hidden" name="snoEdit" id="snoEdit">

            <div class="form-group">
              <label for="title">Note title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="etextHelp">
            </div>
            <div class="form-group">
              <label for="description">Add your note</label>
              <textarea class="form-control" name="descriptionEdit" id="descriptionEdit" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update note</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>



  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Crud</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">about</a>
        </li>

        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Contact us</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>

  <?php
      
      if($insert){
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
  <strong>success!</strong> your note has been inserted successfuly.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
      }
      if($delete){
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
  <strong>success!</strong> your note has been deleted successfuly.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
      }
      if($update){
        echo "<div class='alert alert-success  alert-dismissible fade show' role='alert'>
  <strong>success!</strong> your note has updated inserted successfuly.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
      }
      else{
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
  <strong>Holy guacamole!</strong> You should check in on some of those fields below.
  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
</div>";
      }
      ?>

  <div class="container my-4">

    <h2>Add a note</h2>
    <form action="/crud/index.php" method="post">
      <div class="form-group">
        <label for="title">Note title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="etextHelp">
      </div>
      <div class="form-group">
        <label for="description">Add your note</label>
        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Add note</button>
    </form>
  </div>



  <div class="container">



    <table class="table my-4" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.NO</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>

      </thead>
      <tbody>
        <?php
        $sql = 'SELECT * FROM `notes`' ;
        $result = mysqli_query($conn, $sql);
        $sno=0;

        while($row = mysqli_fetch_assoc($result)){
          // acho var dump ($row)

          $sno = $sno + 1;
          echo"
           <tr>
      <th scope='row'>". $sno ."</th>
      <td>".$row['title']."</td>
      <td>".$row['description']."</td>
      <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>
      <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">delete</button></td>
    </tr>";


          // echo $row['sno'].".title" . $row['title']. "desc is". $row['description'];
          // echo "<br>";
        }

        ?>


      </tbody>
    </table>
  </div>
  <hr>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script>
    let table = new DataTable('#myTable');
  </script>

  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener('click', (e) => {
        console.log('edit',);
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1];
        console.log(title, description);
        titleEdit.value = titleEdit;
        descriptionEdit.value = descriptionEdit;
        snoEdit.value = e.target.id;
        console.log(e.target.id);

        $('#editModal').modal('toggle');

      })
    })


    delete = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener('click', (e) => {
        console.log('edit',);
        sno = e.target.id.substr(1,);
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[0].innerText;

        if(confirm("Are you sure you want to delete this note!")){
          console.log("yes")
          window.location =`/crud/index.php?delete=${sno}`;
        }
        else{
          console.log("no");
        };

      

      })
    })

  </script>

</body>

</html>










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
    $sql = "DELETE FROM notes WHERE sno = $sno";
    mysqli_query($conn, $sql);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['snoEdit'])) {
        $sno = $_POST['snoEdit'];
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $sql = "UPDATE notes SET title = '$title', description = '$description' WHERE sno = $sno";
        $result = mysqli_query($conn, $sql);
        $update = $result ? true : false;
    } else {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = "INSERT INTO notes (title, description, tstamp) VALUES ('$title', '$description', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $insert = $result ? true : false;
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

    <script>
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
    </script>

</body>

</html>
