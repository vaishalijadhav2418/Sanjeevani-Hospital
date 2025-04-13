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

include 'admin_header.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View Slots</title>

   <!-- Include Google Fonts -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;500;600;700&display=swap">
   <link rel="stylesheet" href="style.css">
   <link rel="stylesheet" href="admin_style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   
   <!-- SweetAlert CSS -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
   <style>
      /* CSS for Search Bar */
      .search-bar {
    position: fixed; /* Fixed position to keep it at the top */
    top: 130px; /* Distance from the top of the viewport */
    width: 19%; /* Width of the search bar */
    left: 1370px; /* Position it horizontally in the middle */
    transform: translateX(-50%); /* Center horizontally */
    z-index: 999; /* Ensure it's above other elements */
}

.search-bar input[type="text"] {
    width: calc(100% - 40px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: black;
    color: white;
}

.search-bar button {
    position: absolute;
    top: 0;
    right: 0;
    width: 40px;
    height: 100%;
    background-color: black;
    color: white;
    border: none;
    border-left: 1px solid #ccc;
    border-radius: 0 4px 4px 0;
    cursor: pointer;
}

.search-bar button i {
    color: white;
    font-size: 15px;
    line-height: 40px;
    margin: 0 auto;
    display: block;
    
}
.search-bar input[type="text"]::placeholder {
        color: white; /* Set placeholder text color to white */
    }
/* Adjust the styles as needed */
</style>
</head>
<body>

<section class="custom-slots custom-container">

   <h1 class="heading">View Slots</h1>
   <div class="search-bar">
      <input type="text" id="slot_search" placeholder="Search by date (YYYY-MM-DD)">
      <button onclick="searchSlots()"><i class="fas fa-search"></i></button>
   </div>
   <div class="box-container">
      <?php
         $currentDate = date('Y-m-d');
         $select_slots = $conn->prepare("SELECT * FROM `slots` WHERE `date` >= :currentDate");
         $select_slots->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
         $select_slots->execute();
         if($select_slots->rowCount() > 0){
            while($fetch_slots = $select_slots->fetch(PDO::FETCH_ASSOC)){   
      ?>
      <div class="slot-card" id="slot_<?= $fetch_slots['id']; ?>">
         <div class="slot-info">
         
            <p> Date: <span><?= $fetch_slots['date']; ?></span> </p>
            <p> Slot: <span><?= $fetch_slots['slot']; ?></span> </p>
            <p> Quantity: <span><?= $fetch_slots['quantity']; ?></span> </p>
         </div>
         <div class="slot-actions">
            <a href="update_slot.php?id=<?= $fetch_slots['id']; ?>" class="btn">Update</a>
            <button class="delete-btn" onclick="deleteSlot(<?= $fetch_slots['id']; ?>)">Delete</button>
         </div>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">No slots available!</p>';
         }
      ?>
   </div>
   
</section>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
   function deleteSlot(id) {
      if(confirm("Are you sure you want to delete this slot?")) {
         // Perform AJAX call to delete the slot
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               // Parse JSON response
               var response = JSON.parse(this.responseText);
               // Check the status of the deletion
               if (response.status === 'success') {
                  // Remove the deleted slot from the DOM
                  var deletedSlot = document.getElementById("slot_" + id);
                  if (deletedSlot) {
                     deletedSlot.remove();
                  }
                  // Display SweetAlert message on successful deletion
                  Swal.fire({
                     title: 'Success',
                     text: response.message,
                     icon: 'success',
                     confirmButtonText: 'OK'
                  });
               } else {
                  // Display SweetAlert message on deletion failure
                  Swal.fire({
                     title: 'Error',
                     text: response.message,
                     icon: 'error',
                     confirmButtonText: 'OK'
                  });
               }
            }
         };
         xhttp.open("GET", "delete_slot.php?id=" + id, true);
         xhttp.send();
      }
   }
</script>
<script>
   function searchSlots() {
      // Get the search value from the input field
      var searchValue = document.getElementById("slot_search").value.trim();

      // Get all slot cards
      var slotCards = document.querySelectorAll(".slot-card");

      // Loop through each slot card
      slotCards.forEach(function(card) {
         var dateSpan = card.querySelector("p:nth-child(1) span");
         var slotDate = dateSpan.textContent.trim();
         
         // Check if the slot date contains the search value
         if (slotDate.includes(searchValue)) {
            // Show the slot card if it matches the search
            card.style.display = "block";
         } else {
            // Hide the slot card if it doesn't match the search
            card.style.display = "none";
         }
      });
   }
</script>
</body>
</html>
