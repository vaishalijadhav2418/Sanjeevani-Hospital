<?php
include 'connect.php';
session_start();

// Check if the user is not logged in and redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Ensure that the script stops execution after redirection
}

$user_id = $_SESSION['user_id'];

// Fetch user's appointments from the database
$query = "SELECT * FROM appointments WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check for SQL errors
if ($stmt->errorCode() != "00000") {
    $errorInfo = $stmt->errorInfo();
    echo "SQL Error: " . $errorInfo[2];
}

// Function to delete an appointment
function deleteAppointment($appointment_id) {
    global $conn;
    $query = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($query);
    return $stmt->execute([$appointment_id]);
}

// Check if delete button is clicked
if (isset($_POST['delete_appointment'])) {
    $appointment_id = $_POST['appointment_id'];
    if (deleteAppointment($appointment_id)) {
        // Redirect to view_booking.php after successful deletion
        header("Location: view_booking.php");
        exit();
    } else {
        // Handle deletion failure
        $delete_error = "Failed to delete appointment.";
    }
}
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <style>
        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        td form {
            display: inline-block;
        }

        td form button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }

        td form button:hover {
            background-color: #d32f2f;
        }

        .accepted i {
            color: green;
        }

        .rejected i {
            color: red;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Your Appointments</h1>

<?php if (count($appointments) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Appointment Slot</th>
                <th>Doctor</th>
                <th>Status</th>
                <th>Action</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo $appointment['appointment_date']; ?></td>
                    <td><?php echo $appointment['appointment_slot']; ?></td>
                    <td><?php echo $appointment['doctor']; ?></td>
                    <td class="<?php echo $appointment['accepted'] == 'accepted' ? 'accepted' : 'rejected'; ?>">
                        <i class="fas fa-<?php echo $appointment['accepted'] == 'accepted' ? 'check-circle' : 'times-circle'; ?>"></i>
                    </td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                            <button type="submit" name="delete_appointment">Delete</button>
                        </form>
                    </td>
                    <!-- Add more columns as needed -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No appointments found.</p>
<?php endif; ?>

<?php if (isset($delete_error)): ?>
    <p class="error"><?php echo $delete_error; ?></p>
<?php endif; ?>

</body>
</html>
<?php include 'footer.php'; ?>