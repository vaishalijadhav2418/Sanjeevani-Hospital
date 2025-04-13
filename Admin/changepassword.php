<?php
include 'connect.php';
include 'admin_header.php';

// Initialize variables to hold status messages
$passwordChanged = false;
$errorOccurred = false;

if (!isset($_SESSION['admin_id'])) {
    // Redirect user to login if not logged in
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $confirm_new_pass = $_POST['confirm_new_pass'];

    // Validate and sanitize inputs
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_new_pass = filter_var($confirm_new_pass, FILTER_SANITIZE_STRING);

    // Retrieve user's current password hash from the database
    $admin_id = $_SESSION['admin_id'];
    $select_password = $conn->prepare("SELECT password FROM `admin_users` WHERE id = ?");
    $select_password->execute([$admin_id]);
    $row = $select_password->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Verify old password
        if (password_verify($old_pass, $row['password'])) {
            // Check if new password matches the confirmation
            if ($new_pass === $confirm_new_pass) {
                // Hash the new password
                $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_password = $conn->prepare("UPDATE `admin_users` SET password = ? WHERE id = ?");
                if ($update_password->execute([$hashed_password, $admin_id])) {
                    // Set password changed flag
                    $passwordChanged = true;
                } else {
                    // Set error flag if password update fails
                    $errorOccurred = true;
                }
            } else {
                // Set error flag if passwords do not match
                $errorOccurred = true;
            }
        } else {
            // Set error flag if old password is incorrect
            $errorOccurred = true;
        }
    } else {
        // Set error flag if user data retrieval fails
        $errorOccurred = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Updated class names and styles */
        .custom-container {
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Adjusted alignment */
            padding-top: 30px; /* Added padding */
        }

        .custom-login-wrap {
            width: 320px; /* Decreased width */
            height: 500px;
            background: #fff;
            padding: 30px; /* Adjusted padding */
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }


        .custom-login-wrap:hover {
            transform: scale(1.05);
        }

        .custom-login-html {
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
        }

        .custom-tab {
            font-weight: bold;
            font-size: 24px; /* Increased heading size */
            display: inline-block;
            padding: 10px 20px;
            cursor: pointer;
            
            border-radius: 10px 10px 0 0;
            margin-bottom: -1px;
            text-align: center; /* Center heading text */
        }

        .custom-login-form {
            min-height: 300px;
            position: relative;
            perspective: 1000px;
            transform-style: preserve-3d;
        }

        .custom-group {
            margin-bottom: 20px;
        }

        .custom-label {
            font-size: 18px;
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .custom-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .custom-button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: black;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .custom-button:hover {
            background-color: #45a049;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Check if password changed, error occurred, old password is incorrect, or passwords do not match, and display appropriate messages
    <?php
    if ($passwordChanged) {
        echo "Swal.fire({
            icon: 'success',
            title: 'Password Changed Successfully!',
            showConfirmButton: false,
            timer: 1500
        });";
    } elseif ($errorOccurred) {
        echo "Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Password change failed!',
        });";
    } elseif ($incorrectOldPassword) {
        echo "Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Old password is incorrect!',
        });";
    } elseif ($passwordsDoNotMatch) {
        echo "Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'New password and confirm password do not match!',
        });";
    }
    ?>
</script>

</head>

<body>

<div class="custom-container">
    <form action="" method="post" class="custom-login-wrap">
        <div class="custom-login-html">
            <label for="tab-1" class="custom-tab">Change Password</label>

            <div class="custom-login-form">
                <div class="custom-sign-in-htm">
                    <div class="custom-group">
                        <label for="old_pass" class="custom-label">Old Password</label>
                        <input id="old_pass" name="old_pass" type="password" class="custom-input" required>
                    </div>
                    <div class="custom-group">
                        <label for="new_pass" class="custom-label">New Password</label>
                        <input id="new_pass" name="new_pass" type="password" class="custom-input" required>
                    </div>
                    <div class="custom-group">
                        <label for="confirm_new_pass" class="custom-label">Confirm New Password</label>
                        <input id="confirm_new_pass" name="confirm_new_pass" type="password" class="custom-input" required>
                    </div>
                    <div class="custom-group">
                        <input type="submit" class="custom-button" value="Change Password" name="submit">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>
