<?php
// index.php

// Include connection file
include 'connect.php';

// Start session
session_start();

// Check if user is logged in
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit;
}

// Check if the delete_chat parameter is set
if (isset($_GET['delete_chat'])) {
    // Delete chat messages from the database for the current user
    $sql = "DELETE FROM chatboxmessage WHERE user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Redirect to the same page after deletion
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Hospital Chat</title>
    
    <style>
        
        .chat-container {
            background-color:#afd7d8;
            width: 370px;
            margin: 50px auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 55px;
        }

        .chat-box {
            
            height: 400px;
            overflow-y: scroll;
            margin-bottom: 10px;
        }

        input[type="text"] {
            margin-top: 10px;
            width: 70%;
            padding: 10px;
            margin-right: 10px;
            border-radius: 35px;
        }

        button {
            margin-top: 15px;
            font-weight: bold;
            background-color: #cdfefe;
            padding: 10px 20px;
            margin-right: 10px;
            border-radius: 35px;
            font-size: 18px;
        }
        
        button:hover {
            background-color: #7db3b3;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="chat-container" id="chat-container">
        <div class="chat-box" id="chat-box">
        <h1 style="letter-spacing:2px; "><u>Chat with doctors</u></h1><br>
            <?php
            // Fetch messages from the database for the current user
            $sql = "SELECT * FROM chatboxmessage WHERE user_id = :user_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<p>Patient: " . $row['message'] . "</p>";
                // Check if admin has replied
                if (!empty($row['admin_reply'])) {
                    echo "<p>Doctor: " . $row['admin_reply'] . "</p>";
                } else {
                    echo "<p>Doctor: Reply here...</p>";
                }
            }
            ?>
        </div>
        <input type="text" id="user-input" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
        <button onclick="clearChat()">Clear Chat</button>
        
    </div>

    <script>
        function sendMessage() {
            var message = document.getElementById("user-input").value;
            if (message.trim() != "") {
                var chatBox = document.getElementById("chat-box");
                chatBox.innerHTML += "<p>You: " + message + "</p>";
                document.getElementById("user-input").value = ""; // Clear input field

                // AJAX call to send message to server
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        chatBox.innerHTML += "<p>Doctor: " + this.responseText + "</p>";
                        chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to bottom
                    }
                };
                xhttp.open("POST", "process_message.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("message=" + message);
            }
        }

        function clearChat() {
            document.getElementById("chat-box").innerHTML = ""; // Clear chat box
        }


    </script>

    
</body>
</html>
<?php include 'footer.php'; ?>