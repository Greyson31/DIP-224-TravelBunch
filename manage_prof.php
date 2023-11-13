<?php

include 'config.php';
session_start();
$id = $_SESSION['admin_id'];

if(!isset($id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($id);
   session_destroy();
   header('location:index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Custom CSS -->


</head>
<body>

  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4>Admin - Registered Users & Merchants</h4>
      </div>
      <div class="card-body">

        <table class="table table-bordered">
          <thead>
            <h3>Users</h3>
            <tr>
              <th>User ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $query = "SELECT * FROM user_form";
            $query_run = mysqli_query($conn, $query);

            if(mysqli_num_rows($query_run) > 0) {

              foreach($query_run as $row) {

                ?>
                <tr>
                  <td><?= $row['id']; ?></td>
                  <td><?= $row['name']; ?></td>
                  <td><?= $row['email']; ?></td>
                  <td><a href="edit_users.php?user_id=<?= $row['id'];?>" class = "">Edit</a></td>
                  <form class="" action="manage_prof.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <td><input class="btn-warning btn-sm" type="submit" name="delete" value="Delete User"></td>
                  </form>
                </tr>
                <?php

                if(isset($_POST['delete'])) {

                  $id = $_POST['id'];
                  $select = "DELETE FROM user_form WHERE id= '$id'";
                  $result = mysqli_query($conn, $select);
                }

              }
            }
            else {
              ?>

              <tr>
                <td colspan="5">No Record Found</td>
              </tr>
              <?php
            }
             ?>

          </tbody>
        </table>

        <!--Merchant-->

        <table class="table table-bordered">
          <thead>
            <h3>Merchants</h3>
            <tr>
              <th>Merchant ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $query = "SELECT * FROM merc_form";
            $query_run = mysqli_query($conn, $query);

            if(mysqli_num_rows($query_run) > 0) {

              foreach($query_run as $row) {

                ?>
                <tr>
                  <td><?= $row['id']; ?></td>
                  <td><?= $row['name']; ?></td>
                  <td><?= $row['email']; ?></td>
                  <td><a href="edit_users.php?merc_id=<?= $row['id']; ?>" class = "">Edit</a></td>

                  <form class="" action="manage_prof.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <td><input class="btn-warning btn-sm" type="submit" name="delete" value="Delete User"></td>
                  </form>


                </tr>
                <?php

                if(isset($_POST['delete'])) {

                  $id = $_POST['id'];
                  $select = "DELETE FROM merc_form WHERE id= '$id'";
                  $result = mysqli_query($conn, $select);
                }


              }
            }
            else {
              ?>

              <tr>
                <td colspan="5">No Record Found</td>
              </tr>
              <?php


            }
             ?>

          </tbody>
        </table>
      </div>
    </div>
  </div> <br>

<!--buttons-->
<div class="profile text-center">

  <div class="container-md">
    <a href="admin_prof.php?admin_id=<?php echo $id; ?>" class="btn-primary btn-lg">Back</a>
    <a href="javascript:void(0);" onclick="refreshPage()" class="btn-primary btn-lg">Refresh Page</a>
    <a href="profile.php?logout=<?php echo $id; ?>" class="btn-danger btn-lg">Logout</a>
  </div>
</div>



<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="style2.css">

</body>

<script>
    function refreshPage() {
        // Reload the current page
        location.reload();
    }
</script>
</html>
