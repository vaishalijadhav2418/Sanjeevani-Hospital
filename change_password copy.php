<?php
include 'connect.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's information
$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Change password logic
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if old password matches the one in the database
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $hashed_password = $stmt->fetchColumn();

    if (password_verify($old_password, $hashed_password)) {
        // Check if new password and confirm password match
        if ($new_password === $confirm_password) {
            // Update the password in the database
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->execute([$hashed_new_password, $user_id]);

            // Set success message for display
            $success_message = "Password changed successfully!";
        } else {
            $error_message = "New password and confirm password do not match.";
        }
    } else {
        $error_message = "Old password is incorrect.";
    }
}
?>

<?php include 'header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="style.css">
    <style>

        
        body {
            font-family: Arial, sans-serif;
            background-color:#e6ffff;
        }

        .container {
            width: 300px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 35px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: left;
            margin-top: 0;
            margin-bottom: 20px;
            background-color: transparent;
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-header h2 {
            margin-right: 10px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 35px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 35px;
            cursor: pointer;
            font-size: 20px
        }

        .btn:hover {
            background-color: #45a049;
        }

        .message {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .error {
            color: black;
        }

        .success {
            color: green;
        }
        .splash {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* semi-transparent black */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999; /* ensure it's on top */
}

.splash-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    text-align: center;
}

.splash button {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.splash button:hover {
    background-color: #45a049;
}
    </style>
    
</head>
<body>
    <?php if(isset($success_message) || isset($error_message)): ?>
    <div id="splash" class="splash">
        <div class="splash-content">
            <?php if(isset($success_message)): ?>
                <div class="success"><?php echo $success_message; ?></div>
            <?php elseif(isset($error_message)): ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <button onclick="closeSplash()">OK</button>
        </div>
    </div>
    <script>
        function closeSplash() {
            var splash = document.getElementById('splash');
            splash.style.display = 'none';
        }
    </script>
    <?php endif; ?>

    <div class="container">
        <h2>Change Password</h2>
        <form method="POST" action="">
            <div class="input-group">
                <label>Old Password</label>
                <input type="password" name="old_password" required>
            </div>
            <div class="input-group">
                <label>New Password</label>
                <input type="password" name="new_password" required>
            </div>
            <div class="input-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="change_password">Change Password</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>
