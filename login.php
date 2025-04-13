<?php

include 'connect.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login & Registration Form</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<form action="" method="post">
    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>

            <div class="login-form">
                <div class="sign-in-htm">
                    <div class="group">
                        <label for="email" class="label">Email</label>
                        <input id="email" name="email" type="text" class="input">
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass1" type="password" name="pass1" class="input" data-type="password">
                    </div>
                    
                    <div class="group">
                        <input type="submit" class="button" value="Sign In" name="submit1">
                    </div>
                    <div class="hr"></div>
                    
                </div>

                <div class="sign-up-htm">
                    <div class="group">
                        <label for="user" class="label">Username</label>
                        <input id="user" name="username" type="text" class="input" >
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass" name="pass" type="password" class="input" data-type="password" >
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Repeat Password</label>
                        <input id="rpass" name="rpass" type="password" class="input" data-type="password" >
                    </div>
                    <div class="group">
                        <label for="signup-email" class="label">Email Address</label>
                        <input id="signup-email" name="signup-email" type="text" class="input" >
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="Sign Up" name="submit">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">Already Member?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php
include 'connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    $name = $_POST['username'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $rpass = $_POST['rpass'];
    $rpass = filter_var($rpass, FILTER_SANITIZE_STRING);
    $email = $_POST['signup-email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $normalized_email = strtolower(trim($email));
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE LOWER(TRIM(email)) = ?");
    $select_user->execute([$normalized_email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email already exists!',
                });
              </script>";
    } else {
        if ($pass != $rpass) {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Confirm password not matched!',
                    });
                  </script>";
        } else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            $insert_user = $conn->prepare("INSERT INTO `users` (name, password, email) VALUES (?, ?, ?)");
            $insert_user->execute([$name, $hashed_password, $normalized_email]);
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        text: 'You can now login.',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(() => {
                        window.location.href = 'login.php';
                    });
                  </script>";
        }
    }
}

if (isset($_POST['submit1'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!empty($email)) {
        $select_user = $conn->prepare("SELECT id, password FROM `users` WHERE email = ?");
        $select_user->execute([$email]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($_POST['pass1'], $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Successful!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = 'index.php';
                        });
                      </script>";
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Incorrect password!',
                        });
                      </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'User with this email does not exist!',
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email is empty',
                });
              </script>";
    }
}
?>
</body>
</html>>
<?php include 'footer.php'; ?>