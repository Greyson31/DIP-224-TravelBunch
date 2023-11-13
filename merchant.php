<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $mercInput = mysqli_real_escape_string($conn, $_POST['email']);
   $mercPass = mysqli_real_escape_string($conn, ($_POST['password']));         // Define the regular expression pattern to match email addresses with "@merchant.com"
   $mercPattern = '/@merchant\.com$/';

   $select = mysqli_query($conn, "SELECT * FROM `merc_form` WHERE email = '$mercInput' AND password = '$mercPass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $_SESSION['user_id'] = $row['id'];
      header('location:profile.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

   // Use preg_match to check if the input matches the pattern
   if (preg_match($mercPattern, $mercInput)) {
      if(mysqli_num_rows($select) > 0){
         $row = mysqli_fetch_assoc($select);
         $_SESSION['user_id'] = $row['id'];
         header('location:merc_prof.php');         
      }
   } else {
      echo "Invalid email address. It must contain @merchant.com.";
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login merchant</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style2.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post" enctype="multipart/form-data">
      
      <h3>Merchant Login</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="email" name="email" placeholder="enter email" class="box" required>
      <input type="password" name="password" placeholder="enter password" class="box" required>
      <input type="submit" name="submit" value="login now" class="btn">
      <p>Don't have an account? <a href="merc_reg.php">Register Now</a></p>
   </form>

</div>

</body>
</html>