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
// Check if the form for adding slots is submitted
if(isset($_POST['add_slot'])) {
    $date = $_POST['date'];
    $slot = $_POST['slot'];
    $quantity = $_POST['quantity'];

    // Check if the slot already exists for the given date and time
    $check_duplicate_slot = $conn->prepare("SELECT COUNT(*) FROM `slots` WHERE date = ? AND slot = ?");
    $check_duplicate_slot->execute([$date, $slot]);
    $slot_exists = $check_duplicate_slot->fetchColumn();

    if($slot_exists) {
        echo '<script>alert("Slot already exists for the selected date and time.");</script>';
    } else {
        // Prepare and execute the SQL query to insert the slot into the database
        $insert_slot = $conn->prepare("INSERT INTO `slots` (date, slot, quantity) VALUES (?, ?, ?)");
        $insert_slot->execute([$date, $slot, $quantity]);

        // Check if the slot was successfully inserted
        if($insert_slot) {
            echo '<script>alert("Slot inserted successfully");</script>';
        } else {
            echo '<script>alert("Error inserting slot: ' . $conn->error . '");</script>';
        }
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

   <link rel="stylesheet" href="admin_style.css">
   <link rel="stylesheet" href="style.css">

   <!-- Include SweetAlert library -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">Add Slot</h1>

   <form action="" method="post">
      <div class="flex">
         <div class="inputBox">
            <span>Date</span>
            <!-- Set min attribute to the current date -->
            <input type="date" class="box" name="date" required min="<?php echo date('Y-m-d'); ?>">
         </div>
         <div class="inputBox">
            <span>Slot</span>
            <select name="slot" class="box" required>
               <!-- Generate time slots from 10 am to 8 pm with 1-hour gap -->
               <?php
               // Generate time slots from 10 am to 8 pm with 1-hour gap
               for ($hour = 10; $hour <= 20; $hour++) {
                   // Format the hour in 12-hour format with leading zeros
                   $formattedHour = sprintf('%02d', $hour);
                   // Display the time slot as an option
                   echo "<option value='$formattedHour:00'>$formattedHour:00 AM</option>";
                   echo "<option value='$formattedHour:30'>$formattedHour:30 AM</option>";
               }
               ?>
            </select>
         </div>
         <div class="inputBox">
            <span>Quantity</span>
            <input type="number" min="1" class="box" name="quantity" placeholder="Enter quantity" required>
         </div>
      </div>
      
      <input type="submit" value="Add Slot" class="btn" name="add_slot">
   </form>

</section>

<script src="../js/admin_script.js"></script>
</body>
</html>
