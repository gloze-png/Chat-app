<?php 
include 'php/config.php'; // include the database connection file
session_start();
$user_id = $_SESSION['user_id'];

$get_user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

if(!isset($user_id)){
  header('location:login.php');
}
$select = mysqli_query($conn, "SELECT* FROM user_form WHERE user_id = '$get_user_id' "); //checking if the email is already in use
if(mysqli_num_rows($select) > 0 ) {
  $row = mysqli_fetch_assoc($select);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/main.css">
  <title>Chat Area</title>
</head>
<body>
  <div class="container">
    <section class="chat-area">
      <header>
        <a href="home.php" class="back-icon"><img src="images/arrow.svg" alt=""></a>
   <img src="uploaded_img/<?php print $row['img']?>" alt="avatar">
        <div class="details">
          <span><?php print $row['name']?></span>
          <p><?php print $row['status']?></p>
        </div>
      </header>
      <div class="chat-box">
        <!-- <div class="text">
          <img src="uploaded_img/default-avatar.png" alt="">
          <span>no message are available. once you send message will appear here</span>
        </div>
        <div class="chat outgoing">
          <div class="details">
            <p>hi</p>
            
          </div>
        </div>
         <div class="chat incoming">
          <img src="uploaded_img/default-avatar.png">
          <div class="details">
            <p>hi</p>
        
          </div>
        </div>
         <div class="chat incoming">
          <div class="details">
           
            <p><img src="uploaded_img/default-avatar.png"></p>
          </div>
        </div>
        <div class="chat outgoing">
          <div class="details">
          
            <p><img src="uploaded_img/default-avatar.png"></p>
          </div>
        </div> -->
      </div>
      <form action="" class="typing-area" method="POST">
        <input type="text" name="incoming_id" value="<?php print $get_user_id?>" class="incoming_id" hidden>
        <input type="text" name="message" class="input-field" placeholder="type a message here....">
        <button class="image"><img src="images/camera.svg" alt="" srcset=""></button>
        <input type="file" name="send_image" accept="image/*" class="upload_img" hidden>
        <button class="send_btn" name="send_btn"><img src="images/send.svg" alt=""></button>
      </form>
    </section>
  </div> 
  <script src="js/script.js" defer></script>
</body>
</html>