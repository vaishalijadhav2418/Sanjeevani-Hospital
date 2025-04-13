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

   try {
      // Start a transaction
      $conn->beginTransaction();

      // Delete related appointments
      $delete_appointments = $conn->prepare("DELETE FROM `appointments` WHERE user_id = ?");
      $delete_appointments->execute([$delete_id]);

      // Get the feedback IDs associated with the deleted user's appointments
      $select_feedback_ids = $conn->prepare("SELECT id FROM `feedback_data` WHERE id IN (SELECT id FROM `appointments` WHERE user_id = ?)");
      $select_feedback_ids->execute([$delete_id]);
      $feedback_ids = $select_feedback_ids->fetchAll(PDO::FETCH_COLUMN);

      // Delete feedback associated with the deleted user's appointments
      foreach ($feedback_ids as $feedback_id) {
         $delete_feedback = $conn->prepare("DELETE FROM `feedback_data` WHERE id = ?");
         $delete_feedback->execute([$feedback_id]);
      }

      // Update slots
      $update_slots = $conn->prepare("UPDATE `slots` SET quantity = quantity + 1 WHERE id IN (SELECT appointment_slot FROM `appointments` WHERE user_id = ?)");
      $update_slots->execute([$delete_id]);

      // Delete the user
      $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
      $delete_user->execute([$delete_id]);

      // Commit the transaction
      $conn->commit();

      header('Location: show_users.php'); // Redirect after deletion
      exit(); // Ensure script execution stops after redirection
   } catch (PDOException $e) {
      // Rollback the transaction in case of any error
      $conn->rollBack();
      echo "PDOException: " . $e->getMessage();
   }
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
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="accounts">

   <div class="box-container">
      <?php
         $select_accounts = $conn->prepare("SELECT * FROM `users`");
         $select_accounts->execute();
         if($select_accounts->rowCount() > 0){
            while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
      ?>
      <div class="box">
         <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
         <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
         <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
         
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">no accounts available!</p>';
         }
      ?>
   </div>

</section>

</body>
</html>