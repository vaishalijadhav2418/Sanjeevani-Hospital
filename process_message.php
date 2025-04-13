<?php
// process_message.php

// Include connection file
include 'connect.php';

session_start(); // Start the session

if (isset($_SESSION['user_id']) && isset($_POST['message'])) {
    $user_id = $_SESSION['user_id'];
    $message = $_POST['message'];

    // Store the message in the database
    $stmt = $conn->prepare("INSERT INTO chatboxmessage (user_id, message) VALUES (:user_id, :message)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':message', $message);
    if ($stmt->execute()) {
        echo "Your message '$message' is received. We will get back to you soon.";
    } else {
        echo "Error: Unable to store message.";
    }
} elseif (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
} else {
    echo "No message received.";
}
?>
