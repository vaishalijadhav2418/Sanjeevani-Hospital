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

// Check if slot ID is provided in the URL
if(isset($_GET['id'])) {
    $slot_id = $_GET['id'];

    // Fetch slot details from the database
    $select_slot = $conn->prepare("SELECT * FROM `slots` WHERE id = ?");
    $select_slot->execute([$slot_id]);
    $slot = $select_slot->fetch(PDO::FETCH_ASSOC);
} else {
    // Redirect back to view slots page if slot ID is not provided
    header("Location: show_slots.php");
    exit();
}

// Check if the form for updating slots is submitted
if(isset($_POST['update_slot'])) {
    $new_quantity = $_POST['new_quantity'];

    // Update the slot quantity in the database
    $update_slot = $conn->prepare("UPDATE `slots` SET `quantity` = ? WHERE `id` = ?");
    $update_slot->execute([$new_quantity, $slot_id]);

    // Redirect to the same page with success parameter
    header("Location: update_slot.php?id=$slot_id&success=true");
    exit();
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

   <!-- Include SweetAlert library -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">Update Slot Quantity</h1>

   <form action="" method="post">
      <div class="flex">
         <div class="inputBox">
            <span>Slot ID</span>
            <input type="text" class="box" value="<?= $slot['id'] ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Date</span>
            <input type="text" class="box" value="<?= $slot['date'] ?>" readonly>
         </div>
         <div class="inputBox">
            <span>Current Quantity</span>
            <input type="text" class="box" value="<?= $slot['quantity'] ?>" readonly>
         </div>
         <div class="inputBox">
            <span>New Quantity</span>
            <!-- Allow admin to enter a new quantity -->
            <input type="number" class="box" name="new_quantity" placeholder="Enter new quantity" required>
         </div>
      </div>
      
      <input type="submit" value="Update Quantity" class="btn" name="update_slot">
   </form>

</section>

<script src="../js/admin_script.js"></script>

<?php
// Check if the URL parameter 'success' is set, indicating successful slot update
if(isset($_GET['success']) && $_GET['success'] == 'true') {
    echo "<script>
            Swal.fire({
                title: 'Success',
                text: 'Slot quantity updated successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            });
          </script>";
}
?>

</body>
</html>