<?php 
include 'php/config.php'; // include the database connection file
$image_rename = 'default-avatar.png'; // this is a default picture
if(isset($_POST['submit'])){ // if the form is submitted or clicked
  $ran_id = rand(time(), 1000000000); // creating random number

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, md5($_POST['password']));
  $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
// declaring variables

if(filter_var($email, FILTER_VALIDATE_EMAIL )){ // checking if the email is correct
  $image = $_FILES['image']['name']; // user image name
  $image_size = $_FILES['image']['size']; // user image size
  $image_tmp_name =$_FILES['image']['size'];
  $image_rename = $image;
  $image_folder = 'uploaded_img/'.$image_rename; // image folder
  $status = 'Active Now'; // user status

  $select = mysqli_query($conn, "SELECT* FROM user_form WHERE email='$email'
                           AND password = '$password' "); //checking if the email is already in use
 if(mysqli_num_rows($select) >0 ) {
   $alert[] = "user already exist";
 } else {
  if($password != $cpassword){
    $alert[] = "password not match";
  }elseif($image_size > 2000000){
    $alert[] = "image size is too large";
  }else{
   $insert = mysqli_query($conn, " INSERT INTO `user_form`( `user_id`,`name`, `email`, `password`, `img`, `status`) VALUES ('$ran_id','$name','$email','$password','$image_rename','$status') ");
   //inserting user data into database
   if($insert){ // if insert
    move_uploaded_file($image_tmp_name, $image_folder); //moving image file
    header('location:login.php');
    }else{
      $alert[] = "try again";
 }   
}
 }                    


}else{
  $alert[] = "$email is not correct";
}
}
?>


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
      <h1>Create Account</h1>
      <?php 
      if(isset($alert)){
        foreach($alert as $alert){
          print '<div class="alert">'.$alert.'</div>';
        }
      }
      ?>
      <input type="text" name="name" placeholder="Enter username" class="box" required>
      <input type="email" name="email" placeholder="Enter mail" class="box" required>
      <input type="password" name="password" placeholder="Enter password" class="box" required>
      <input type="password" name="cpassword" placeholder="Confirm password" class="box" required>
      <input type="file" name="image" class="box" accept="image/*">
        <input type="submit" name="submit" class="btn" value="chat now">
        <p>Already have an account?<a href="login.html">Login Now</a></p>
    </form>

  </div>
  
</body>
</html>