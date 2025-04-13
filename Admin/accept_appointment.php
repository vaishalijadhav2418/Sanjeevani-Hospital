<?php
include 'connect.php';

if(isset($_POST['accept_appointment'])) {
    // Get the appointment ID from the form
    $appointment_id = $_POST['appointment_id'];

    // Update the appointment status to 'accepted' in the database
    $update_query = "UPDATE appointments SET accepted = 'accepted' WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->execute([$appointment_id]);

    // Redirect back to the page where the appointment was accepted
    header("Location: show_appointments.php");
    exit();
} else {
    // If the form is not submitted properly, redirect to an error page
    header("Location: error.php");
    exit();
}
?>
