<?php

include '../connect.php';

$response = array();

if(isset($_GET['id'])){
   $delete_id = $_GET['id'];
   $delete_slot = $conn->prepare("DELETE FROM `slots` WHERE id = ?");
   if ($delete_slot->execute([$delete_id])) {
      // Deletion was successful
      $response['status'] = 'success';
      $response['message'] = 'Slot deleted successfully';
   } else {
      // Deletion failed
      $response['status'] = 'error';
      $response['message'] = 'Failed to delete slot';
   }
} else {
   // ID not provided
   $response['status'] = 'error';
   $response['message'] = 'Slot ID not provided';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);