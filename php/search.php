<?php
session_start();
include 'config.php';
$outgoing_id = $_SESSION['user_id'];
$searchOn = mysqli_real_escape_string($conn, $_POST['searchOn']);
$sql = "SELECT * FROM user_form WHERE NOT user_id = {$outgoing_id} 
       AND(name LIKE '%($searchOn)%'  OR email LIKE '%($searchOn)%')";
$query = mysqli_query($conn, $sql);
$output = "";
if(mysqli_num_rows($query) == 0){
  $output .= "No users are available to chat";
  }elseif(mysqli_num_rows($query) > 0){
    include 'user_data.php';
   // while($row= mysqli_fetch_assoc($query)){
    // $output .= ' <a href="chat.php">
    //       <div class="content">
    //         <img src="uploaded_img/' . $row['name'] . '" alt="profile pictures">
    //         <div class="details">
    //           <span>' . $row['name'] . '</span>
    //           <p>Hello brotherly</p>
    //         </div>  
    //       </div>
    //       <div class="status-dot"></div>
    //     </a>';

  }
//}
print $output;
?>