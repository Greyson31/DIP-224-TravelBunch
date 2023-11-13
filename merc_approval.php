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
        <h4>Admin - Manage Merchant Approval</h4>
      </div>
      <div class="card-body">


        <form class="" action="merc_approval.php" method="post">
          <!--Merchant-->

          <table class="table table-bordered">
            <thead>
              <h3>Merchants</h3>
              <tr>
                <th>Merchant ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Edit</th>
                <th>Status</th>
                <th>Approval</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $query = "SELECT * FROM merc_form;";
              $result = mysqli_query($conn, $query);

              if(mysqli_num_rows($result) > 0) {
                foreach($result as $row) {
                  if ($row["status"] == "") {
                  ?><tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><a href="edit_users.php?merc_id=<?= $row['id']; ?>" class = "">Edit</a></td>


                    <td>Pending</td>

                    <td>
                      <form class="" action="merc_approval.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="approve" value="Approve" class="btn-success btn-sm">
                        <input type="submit" name="deny" value="Deny" class="btn-warning btn-sm">
                      </form>
                    </td>
                  </tr>
                  <?php
                  }
                  ?>
                  
                  <?php

                  if(isset($_POST['approve'])) {
                    $id = $_POST['id'];
                    $select = "UPDATE merc_form SET status = 'Approved' WHERE id = '$id'";
                    $result = mysqli_query($conn, $select);
                  }

                  if (isset($_POST['deny'])) {
                    $id = $_POST['id'];
                    $select = "DELETE FROM merc_form WHERE id = '$id'";
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
        </form>

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
