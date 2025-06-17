<?php 
include 'php/config.php'; // include the database connection file
session_start();
if(isset($_POST['submit'])){ // if the form is submitted or clicked

  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, md5($_POST['password']));
  
// declaring variables

if(filter_var($email, FILTER_VALIDATE_EMAIL )){ // checking if the email is correct
  $select = mysqli_query($conn, "SELECT* FROM user_form WHERE email='$email'
                           AND password = '$password' "); //checking if the email and password are correct
 if(mysqli_num_rows($select) > 0 ) {
  $row = mysqli_fetch_assoc($select);
  $status = 'Active Now'; //user status

// $user_id = $row['user_id'];
 $update = mysqli_query($conn, "UPDATE user_form SET status = '$status' WHERE user_id = '($row[user_id])' ");
 
 if($update){
  $_SESSION['user_id'] = $row['user_id']; // storing the user id in
  header('location: home.php');
 }

}else{
  $alert[] = 'Invalid Email or Password';
}
  }else{
  $alert[] = "$email is not correct";
  }}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Back</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
      <h1>Welcome Back</h1>
       <?php 
      if(isset($alert)){
        foreach($alert as $alert){
          print '<div class="alert">'.$alert.'</div>';
        }
      }
      ?> 
      <input type="email" name="email" placeholder="Enter mail" class="box" required>
      <input type="password" name="password" placeholder="Enter password" class="box" required>
       <input type="submit" name="submit" class="btn" value="chat now">
        <p>Don't have an account yet?<a href="index.php">Create an account</a></p>
    </form>
  </div>
</body>
</html>