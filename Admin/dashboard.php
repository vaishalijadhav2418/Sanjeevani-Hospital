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
?>
<?php include 'admin_header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>  
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<section class="dashboard">
    <div class="box-container">
        <div class="box">
            <?php
                $current_date = date('Y-m-d');
                $select_appointments = $conn->prepare("SELECT * FROM `appointments` WHERE appointment_date = ?");
                $select_appointments->execute([$current_date]);
                $number_of_appointments = $select_appointments->rowCount();
            ?>
            <h3><?= $number_of_appointments; ?></h3>
            <p>Appointments</p>
            <a href="show_appointments.php" class="btn">See Appointments</a>
        </div>
        <div class="box">
            <?php
                $select_slots = $conn->prepare("SELECT * FROM `slots` WHERE date = ?");
                $select_slots->execute([$current_date]);
                $number_of_slots = $select_slots->rowCount();
            ?>
            <h3><?= $number_of_slots; ?></h3>
            <p>Slots</p>
            <a href="show_slots.php" class="btn">See Slots</a>
        </div>
        <div class="box-container">
            <div class="box">
                <?php
                    $select_users = $conn->prepare("SELECT * FROM `users`");
                    $select_users->execute();
                    $number_of_users = $select_users->rowCount();
                ?>
                <h3><?= $number_of_users; ?></h3>
                <p>Normal Users</p>
                <a href="show_users.php" class="btn">See Users</a>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <?php
                    $select_contacts = $conn->prepare("SELECT * FROM `contacts`");
                    $select_contacts->execute();
                    $number_of_contacts = $select_contacts->rowCount();
                ?>
                <h3><?= $number_of_contacts; ?></h3>
                <p>Contact Messages</p>
                <a href="showcontact_messages.php" class="btn">See Messages</a>
            </div>
            <div class="box">
                <?php
                    $select_feedback = $conn->prepare("SELECT * FROM `feedback_data`");
                    $select_feedback->execute();
                    $number_of_feedback = $select_feedback->rowCount();
                ?>
                <h3><?= $number_of_feedback; ?></h3>
                <p>Feedback</p>
                <a href="show_feedback.php" class="btn">See Feedback</a>
            </div>
        </div>
    </div>
</section>
</body>
</html>
