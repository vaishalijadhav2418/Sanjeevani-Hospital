<?php

include 'connect.php';
session_start();

// Check if the admin_id is set in the session
if (isset($_SESSION['admin_id'])) {
    $admin_id = $_SESSION['admin_id'];
} else {
    // Redirect to the login page if admin is not logged in
    header('location: admin_login.php');
    exit(); // Stop further execution
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `feedback_data` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:show_feedback.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="admin_style.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">Feedback</h1>

<div class="box-container">

   <?php
      $select_messages = $conn->prepare("SELECT * FROM `feedback_data`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
   <p> ID: <span><?= $fetch_message['id']; ?></span></p>
   <p> Name: <span><?= $fetch_message['name']; ?></span></p>
   <p> Email: <span><?= $fetch_message['email']; ?></span></p>
   <p> Doctor: <span><?= $fetch_message['doctor']; ?></span></p>
   <p> Doctor Rating: <span><?= $fetch_message['doctor_rating']; ?></span></p>
   <p> Feedback: <span><?= $fetch_message['feedback']; ?></span></p>
   </div>
   <?php
         }
      } else {
         echo '<p class="empty">You have no messages</p>';
      }
   ?>

</div>

</section>

   
</body>
</html>