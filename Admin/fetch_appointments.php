<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <style>
    .action-buttons {
        display: flex;
        justify-content: space-between;
    }

    .action-buttons form {
        margin-right: 10px;
    }

    .action-buttons button {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .action-buttons button[type="submit"] {
        background-color: #4CAF50; /* Green */
        color: white;
    }

    .action-buttons button[type="submit"]:hover {
        background-color: #45a049; /* Darker green */
    }

    .action-buttons button[type="button"] {
        background-color: #f44336; /* Red */
        color: white;
    }

    .action-buttons button[type="button"]:hover {
        background-color: #d32f2f; /* Darker red */
    }
</style>

</head>
<body>
<?php
include 'connect.php';

// Check if the selected date is passed via POST
if(isset($_POST['date'])) {
    // Get the selected date
    $selectedDate = $_POST['date'];

    // Prepare and execute SQL query to fetch appointments for the selected date
    $select_appointments = $conn->prepare("SELECT * FROM `appointments` WHERE appointment_date = ?");
    $select_appointments->execute([$selectedDate]);

    // Check if appointments are found for the selected date
    if($select_appointments->rowCount() > 0) {
        // Loop through the fetched appointments and display them
        while($fetch_appointment = $select_appointments->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="box">
                <p>Name: <span><?= $fetch_appointment['name']; ?></span></p>
                <p>Phone: <span><?= $fetch_appointment['phone']; ?></span></p>
                <p>Email: <span><?= $fetch_appointment['email']; ?></span></p>
                <p>Doctor: <span><?= $fetch_appointment['doctor']; ?></span></p>
                <p>First Visit: <span><?= $fetch_appointment['first_visit']; ?></span></p>
                <p>Appointment Date: <span><?= $fetch_appointment['appointment_date']; ?></span></p>
                <p>Appointment Slot: <span><?= $fetch_appointment['appointment_slot']; ?></span></p>
                <p>Accepted: <span><?= ucfirst($fetch_appointment['accepted']); ?></span></p>
                <!-- Accept and Reject buttons with data-id attribute containing appointment ID -->
                <div class="action-buttons">
                    <form method="POST" action="accept_appointment.php">
                        <input type="hidden" name="appointment_id" value="<?= $fetch_appointment['id']; ?>">
                        <button type="submit" name="accept_appointment">Accept</button>
                    </form>
                    <form method="POST" action="reject_appointment.php">
                        <input type="hidden" name="appointment_id" value="<?= $fetch_appointment['id']; ?>">
                        <button type="submit" name="reject_appointment">Reject</button>
                    </form>
                </div>
            </div>
            <?php
        }
    } else {
        // If no appointments found for the selected date, display a message
        echo '<p class="empty">No appointments found for this date</p>';
    }
} else {
    // If the date is not passed via POST, display an error message
    echo '<p class="empty">Invalid request</p>';
}
?>
