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

<div class="container mt-5">

   <div class="profile text-center">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `admin_form` WHERE id = '$id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['image'] == ''){
            echo '<img src="images/default-avatar.png" class="img-fluid">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['image'].'" class="img-fluid">';
         }
      ?>
      <h3><?php echo "Logged in as: ", $fetch['name'], " [Admin]"; ?></h3>
      <a href="manage_prof.php?admin_id=<?php echo $id; ?>" class="btn btn-secondary">Manage Users</a>
      <a href="merc_approval.php?admin_id=<?php echo $id; ?>" class="btn btn-secondary">Manage Merchant Approval</a>
      <a href="view_reviews.php?admin_id=<?php echo $id; ?>" class="btn btn-secondary">View Reviews & Ratings</a>
      <a href="index.php" class="btn btn-secondary">Back</a>
      <a href="profile.php?logout=<?php echo $id; ?>" class="btn btn-danger">Logout</a>
      <p>New <a href="index.php">login</a> or <a href="register.php">register</a></p>
   </div>

</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="style2.css">

</body>
</html>
