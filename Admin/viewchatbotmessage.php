<?php
// admin_panel.php

// Include connection file
include 'connect.php';

// Start session
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    // Redirect to login page or display an error message
    header("Location: admin_login.php");
    exit();
}

// Fetch all messages from the database along with the username of the sender
$sql = "SELECT c.*, u.name AS username 
        FROM chatboxmessage c 
        JOIN users u ON c.user_id = u.id
        ORDER BY c.user_id"; // Order by user ID to group messages by user
$stmt = $conn->query($sql);

// Process replies
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['message_id'], $_POST['reply'])) {
        $messageId = $_POST['message_id'];
        $reply = $_POST['reply'];

        // Insert admin reply into the database
        $stmt = $conn->prepare("UPDATE chatboxmessage SET admin_reply = :admin_reply WHERE id = :message_id");
        $stmt->bindParam(':admin_reply', $reply);
        $stmt->bindParam(':message_id', $messageId);
        $success = $stmt->execute();

        if ($success) {
            // Set success message in session
            $_SESSION['reply_success'] = true;
            // Redirect back to the previous page
            header("Location: viewchatbotmessage.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Hospital Chat</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add custom styles here */
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px; /* Increased margin */
            background-color: #fff; /* Set background color to white */
            font-size: 18px; /* Increased font size */
            padding: 10px;
            text-align: center; /* Center align content within the card */
        }

        .card p {
            margin: 5px 0;
        }

        .card form {
            display: flex;
            flex-direction: column; /* Align form items vertically */
        }

        .card input[type="text"] {
            padding: 5px;
            margin-bottom: 10px; /* Increased margin */
        }

        .card button {
            padding: 5px 10px;
            background-color: #000; /* Set button background color to black */
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="container">
        <h2>Chatbox Messages</h2>
        <?php
        $currentUserId = null; // Variable to store the current user ID
        // Display all messages along with the username
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Check if the user ID has changed
            if ($row['user_id'] !== $currentUserId) {
                // If yes, close the previous card and start a new card
                if ($currentUserId !== null) {
                    echo "</div>"; // Close previous card
                }
                $currentUserId = $row['user_id']; // Update current user ID
                // Start a new card for the current user
                echo "<div class='card'>";
                echo "<p>Name: " . $row['username'] . "</p>";
            }
            // Display message content
            echo "<p>Message: " . $row['message'] . "</p>";
            // Display form for admin reply
            echo "<form method='POST'>";
            echo "<input type='hidden' name='message_id' value='" . $row['id'] . "'>";
            echo "<input type='text' name='reply' placeholder='Reply here...'>";
            echo "<button type='submit'>Send</button>";
            echo "</form>";
        }
        // Close the last card
        echo "</div>";
        ?>
    </div>

    <?php
    // Check if success message is set in session
    if(isset($_SESSION['reply_success']) && $_SESSION['reply_success'] === true) {
        // Display success message
        echo "<script>alert('Reply sent successfully!');</script>";
        // Unset the session variable
        unset($_SESSION['reply_success']);
    }
    ?>

</body>
</html>
