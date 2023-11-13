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
        <h4>Admin - View Ratings & Reviews</h4>
      </div>
      <div class="card-body">


        <form class="" action="merc_approval.php" method="post">
          <!--Merchant-->

          <table class="table table-bordered">
            <thead>
              <h3>Reviews & Ratings</h3>
              <tr>
                <th>User ID</th>
                <th>Rating</th>
                <th>Review</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $query = "SELECT review.description, review.rating, user_form.name, user_form.id FROM review INNER JOIN user_form ON review.user_id = user_form.id UNION ALL SELECT review.description, review.rating, merc_form.name, merc_form.id FROM review INNER JOIN merc_form ON review.merc_id = merc_form.id";
              $result = mysqli_query($conn, $query);

              if(mysqli_num_rows($result) > 0) {
                foreach($result as $row) {
                  
                  

                  ?>
                  <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['rating']; ?> / 5</td>
                    <td><?= $row['description']; ?></td>
                  </tr>
                  <?php

                  if(isset($_POST['approve'])) {

                    $id = $_POST['id'];
                    $select = "UPDATE merc_form SET status = 'Approved' WHERE id = '$id'";
                    $result = mysqli_query($conn, $select);
                  }

                  if (isset($_POST['deny'])) {

                    $id = $_POST['id'];
                    $select = "UPDATE merc_form SET status = 'Deny' WHERE id = '$id'";
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
