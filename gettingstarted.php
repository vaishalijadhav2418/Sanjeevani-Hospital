<?php
include 'connect.php';
session_start();

// Check if the user is not logged in and redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Ensure that the script stops execution after redirection
}

$user_id = $_SESSION['user_id'];

?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="style.css">
    <title>Health Assessment Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        .icon-option {
            display: inline-block;
            margin-right: 20px;
        }

        .icon {
            font-size: 2rem;
            cursor: pointer;
        }

        .icon.selected {
            color: blue; /* Change color as needed */
        }

        form {
            margin-top: 20px;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Health Assessment Test</h2>
        <form action="submit_assessment.php" method="post">
            <p>Is this assessment for yourself or someone else?</p>
            <div class="icon-option">
                <input type="hidden" name="for_self" value="self">
                <i class="fas fa-user icon" title="Myself" onclick="selectOption(this)"></i> <!-- Font Awesome icon for Myself -->
            </div>
            <div class="icon-option">
                <input type="hidden" name="for_self" value="other">
                <i class="fas fa-user-friends icon" title="Someone else" onclick="selectOption(this)"></i> <!-- Font Awesome icon for Someone else -->
            </div>

            <p>Question 1: What is the age of the person being assessed?</p>
            <input type="number" name="age" required>

            <p>Question 2: What symptoms are being experienced?</p>
            <select name="symptoms[]" multiple required>
                <option value="fever">Fever</option>
                <option value="cough">Cough</option>
                <option value="shortness_of_breath">Shortness of breath</option>
                <option value="fatigue">Fatigue</option>
                <!-- Add more symptoms as needed -->
            </select>

            <!-- Add more questions as needed -->

            <button type="submit">Submit</button>
        </form>
    </div>
    <script>
        function selectOption(element) {
            var icons = document.querySelectorAll('.icon');
            icons.forEach(function(icon) {
                icon.classList.remove('selected');
            });
            element.classList.add('selected');
            var hiddenInput = element.parentNode.querySelector('input[type="hidden"]');
            hiddenInput.value = element.title;
        }
    </script>
</body>
</html>
<?php include 'footer.php'; ?>