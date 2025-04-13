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

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    // Retrieve appointment details before deleting
    $select_appointment = $conn->prepare("SELECT * FROM `appointments` WHERE id = ?");
    $select_appointment->execute([$delete_id]);
    $appointment = $select_appointment->fetch(PDO::FETCH_ASSOC);

    // Delete the appointment
    $delete_message = $conn->prepare("DELETE FROM `appointments` WHERE id = ?");
    $delete_message->execute([$delete_id]);

    // Check if appointment is deleted successfully
    if ($delete_message) {
        // Increment slot count for the appointment's date and slot time
        $update_slot_count = $conn->prepare("UPDATE `slots` SET quantity = quantity + 1 WHERE date = ? AND slot = ?");
        $update_slot_count->execute([$appointment['appointment_date'], $appointment['appointment_slot']]);
        header('location:show_appointments.php');
    } else {
        // Handle error if deletion fails
        echo "Error deleting appointment: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="style.css">

    <!-- Include SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Include jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <style>
    /* CSS for the small card and centering it */
    .showcontainer {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70px; /* Set height to 100% of viewport height */
        padding-bottom: 20px;
    }

    .small-card {
        background-color: white;
        border: 1px solid black;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 330px;
        height: 80px;
        
    }

    .small-card h2 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #333;
    }

    .small-card p {
        color: #666;
        line-height: 1.5;
    }

    .small-card .button-container {
        margin-top: 20px;
    }

    .small-card .btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .small-card .btn:hover {
        background-color: #0056b3;
    }

    /* Calendar styling */
    .calendar {
        margin-bottom: 20px;
    }

    /* Change color and font of select date label */
    .calendar label {
        color: #333;
        font-weight: bold;
        font-size: 16px;
    }

    /* Change color and font of select date input */
    #appointment_date {
        color: #333;
        font-size: 16px;
        padding: 10px;
        border: 1px solid black;
        border-radius: 4px;
        width: 100%;
        background-color: white;
        
    }

    /* Increase size of calendar input */
    @media (min-width: 768px) {
        #appointment_date {
            width: auto;
        }
    }
</style>

</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="contacts">

    <h1 class="heading">Appointments</h1>

    <!-- Container to hold the small card and center it -->
    <div class="showcontainer">
        <!-- Small card to hold the calendar -->
        <div class="small-card">
            <!-- Calendar to select date -->
            <div class="calendar">
                <label for="appointment_date">Select Date:</label>
                <!-- Set min attribute to the current date -->
                <input type="date" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>
    </div>

    <!-- Container to display appointments -->
    <div class="box-container" id="appointments_container">
        <!-- Appointments will be displayed here -->
    </div>

</section>

<!-- JavaScript for SweetAlert confirmation and AJAX call -->
<script>
    // Add event listener to the appointment_date input
    $('#appointment_date').change(function() {
        // Get the selected date value
        var selectedDate = $(this).val();
        // Make AJAX call to fetch appointments for the selected date
        $.ajax({
            type: 'POST',
            url: 'fetch_appointments.php',
            data: {date: selectedDate},
            success: function(response) {
                // Display fetched appointments in the container
                $('#appointments_container').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Add event listeners to delete buttons
    $('.delete-btn').click(function(event) {
        event.preventDefault();
        const appointmentId = $(this).data('id');
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Delete Appointment?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            // If user confirms deletion, redirect to delete script
            if (result.isConfirmed) {
                window.location.href = `show_appointments.php?delete=${appointmentId}`;
            }
        });
    });
</script>

</body>
</html>
