<?php

include 'config.php';
session_start();

function acc_type(&$id, &$table) {
}
if (isset($_GET['user_id'])) {
   $id = $_GET['user_id'];
   $table = "user_form";
}

if (isset($_GET['merc_id'])) {
   $id = $_GET['merc_id'];
   $table = "merc_form";
}

if(isset($_POST['update_profile'])){
   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   mysqli_query($conn, "UPDATE `$table` SET name = '$update_name', email = '$update_email' WHERE id = '$id'") or die('query failed');

   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, ($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, ($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, ($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `$table` SET password = '$confirm_pass' WHERE id = '$id'") or die('query failed');
         $message[] = 'password updated successfully!';
      }
   }

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `$table` SET image = '$update_image' WHERE id = '$id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated successfully!';
      }
   }

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

  <div class="col-mt-12">
    <div class="card">
      <div class="card-header">
        <h4>Edit User</h4>
      </div>
      <div class="container mt-5">

         <?php
            $select = mysqli_query($conn, "SELECT * FROM `$table` WHERE id = '$id'") or die('query failed');
            if(mysqli_num_rows($select) > 0){
               $fetch = mysqli_fetch_assoc($select);
            }
         ?>

         <form action="" method="post" enctype="multipart/form-data">
            <?php
               if($fetch['image'] == ''){
                  echo '<img src="images/default-avatar.png" class="img-fluid">';
               }else{
                  echo '<img src="uploaded_img/'.$fetch['image'].'" class="img-fluid">';
               }
               if(isset($message)){
                  foreach($message as $message){
                     echo '<div class="alert alert-info">'.$message.'</div>';
                  }
               }
            ?>
            <div class="row">
               <div class="col-md-6">
                  <div class="form-group">
                     <label for="update_name">Username:</label>
                     <input type="text" name="update_name" value="<?php echo $fetch['name']; ?>" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="update_email">Email:</label>
                     <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="update_image">Update Picture:</label>
                     <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="form-control">
                  </div>
               </div>
               <div class="col-md-6">
                  <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                  <div class="form-group">
                     <label for="update_pass">Old Password:</label>
                     <input type="password" name="update_pass" placeholder="Enter previous password" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="new_pass">New Password:</label>
                     <input type="password" name="new_pass" placeholder="Enter new password" class="form-control">
                  </div>
                  <div class="form-group">
                     <label for="confirm_pass">Confirm Password:</label>
                     <input type="password" name="confirm_pass" placeholder="Confirm new password" class="form-control">
                  </div>
               </div>
            </div>
            <button type="submit" class="btn btn-primary" name="update_profile">Update Profile</button>
            <a href="manage_prof.php?admin_id=<?php echo $id; ?>" class="btn btn-primary">Back</a>
         </form>

      </div>






      </div>



<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="style2.css">

</body>
</html>
