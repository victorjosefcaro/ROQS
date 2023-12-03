<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['username']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM users WHERE username = '$username' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         header('location:index.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         header('location:staff_panel/index.php');

      }
     
   }else{
      $error[] = 'incorrect username or password!';
   }

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login Form</title>

   <!-- Custom CSS file link  -->
   <link rel="stylesheet" href="css/style.css">

   <!-- Fixed-size icon -->
   <link rel="icon" href="logo1.png" sizes="64x64" type="image/png">

   <!-- You can add other icon sizes if needed -->
   <link rel="icon" href="logo1.png" sizes="192x192" type="image/png">
</head>
<body>
   
<div class="form-container">

   <form action="" method="post">

         
            <div class="logo-container">
            <img src="logo1.png" alt="Logo" class="logo">
            </div>

      <h3>Login Now</h3>
      
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="username" name="username" required placeholder="Enter your username">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login Now" class="form-btn">
   </form>

      
</div>

</body>
</html>
