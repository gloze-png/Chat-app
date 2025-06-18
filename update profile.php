<?php 
include 'php/config.php'; // include the database connection file
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
  header('location:login.php');
}
$select = mysqli_query($conn, "SELECT* FROM user_form WHERE user_id = '$user_id' "); //checking if the email is already in use
if(mysqli_num_rows($select) > 0 ) {
  $row = mysqli_fetch_assoc($select);
}
if (isset($_POST['update_profile'])){
  $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
  $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

   $update_name = mysqli_query($conn, "UPDATE user_form SET name = '$update_name'
                                        WHERE user_id = '$user_id' "); //update the user details
 if($update_name){
   $alert[] = "name update successful!";
 }                                       

// if(!empty($update_email)){
  if(filter_var($update_email, FILTER_VALIDATE_EMAIL )){ // checking if the email is correct
    $update_email = mysqli_query($conn, "UPDATE user_form SET email = '$update_email'
              WHERE user_id = '$user_id' "); //update the user details  

    //header('location: update_profile.php');

  }else{
    $alert[] = "email is not valid email !";
}

// if($update){
//   header('location:update profile.php'); 
// }
  $image = $_FILES['image']['name']; // user image name
  $image_size = $_FILES['image']['size']; // user image size
  $image_tmp_name =$_FILES['image']['tmp_name'];
  $image_rename = $image;
  $image_folder = 'uploaded_img/'.$image_rename; // image folder

  if(!empty($image)){
    if($image_size > 2000000){
    $alert[] = "image size is too large";
    } else{
       $update_img = mysqli_query($conn, "UPDATE user_form SET name = '$image'
                                       WHERE user_id = '$user_id' ");
 move_uploaded_file($image_tmp_name, $image_folder);
    header('location:update profile.php');
    }
  }
  $main_pass = $row['password'];
  $old_pass = mysqli_real_escape_string($conn, md5($_POST['old_pass']));
  $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
  $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

  if(!empty($old_pass) || !empty($new_pass)|| !empty($confirm_pass)){
    if($old_pass != $main_pass){
      $alert[] = "old password is incorrect";
      } elseif($new_pass != $confirm_pass){
        $alert[] = "confirm password do not match";
        } else{
            $update_pass = mysqli_query($conn, "UPDATE user_form SET name = '$confirm_pass'
                                       WHERE user_id = '$user_id' ");
          // header('loction:update_profile.php');
            $alert[] = "password update successfully";
    }
  }
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css">
  <title>Update Profile</title>
</head>
<body>
  <div class="update-profile">
    <form action="" method="post" enctype="multipart/form-data">
      <a href="update profile.php">
        <img src="uploaded_img/<?php print $row['img']?>" alt="avatar"></a>
      <?php 
      if(isset($alert)){
        foreach($alert as $alert){
          print '<div class="alert">'.$alert.'</div>';
        }
      }
      ?>
      <div class="flex">
        <div class="inputBox">
          <span>username:</span>
          <input type="text" name="update_name" value="<?php print $row['name']?>" class="box">
           <span>email:</span> 
          <input type="email" name="update_email" value="<?php print $row['email']?>" class="box">
          <span>update your Picture</span>
          <input type="file" name="update_image" accept="image/*" class="box">
        </div>

         <div class="inputBox">
          <span>old password:</span>
          <input type="password" name="old_pass" class="box">
           <span>new password:</span> 
          <input type="password" name="new_pass" class="box">
          <span>confirm password</span>
          <input type="password" name="confirm_pass" class="box">
        </div>
      </div>
      <div class="flex btns">
        <input type="submit" value="update profile" name="update profile" class="btn">
        <a href="home.php" class="delete-btn">Go back</a>
      </div>
    </form>
  </div>
</body>
</html>