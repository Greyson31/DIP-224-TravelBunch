<?php
include 'config.php';

if (isset($_POST['submit'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $mercInput = mysqli_real_escape_string($conn, $_POST['email']);
   $mercPass = mysqli_real_escape_string($conn, ($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, ($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image;
   $mercPattern = '/@merchant\.com$/';

   if (preg_match($mercPattern, $mercInput)) {
       // Email contains "@merchant.com"
       $select = mysqli_query($conn, "SELECT * FROM `merc_form` WHERE email = '$mercInput' AND password = '$mercPass'") or die('query failed');

       if (mysqli_num_rows($select) > 0) {
           $message[] = 'User already exists';
       } else {
           if ($mercPass != $cpass) {
               $message[] = 'Confirm password not matched!';
           } elseif ($image_size > 2000000) {
               $message[] = 'Image size is too large!';
           } else {
               $insert = mysqli_query($conn, "INSERT INTO `merc_form`(name, email, password, image) VALUES('$name', '$mercInput', '$mercPass', '$image')") or die('query failed');

               if ($insert) {
                   move_uploaded_file($image_tmp_name, $image_folder);
                   $message[] = 'Registered successfully!';
                   header('location:index.php');
               } else {
                   $message[] = 'Registration failed!';
               }
           }
       }
   } else {
       $message[] = 'Invalid email address. It must contain @merchant.com.';
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>


   <link rel="stylesheet" href="style2.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Merchant Register</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="enter username" class="box" required>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm password" class="box" required>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="index.php">login now</a></p>
   </form>

</div>
</body>
</html>