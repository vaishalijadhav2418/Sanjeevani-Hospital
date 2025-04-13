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

if (isset($_POST['submit'])) {
    // Retrieve start and end dates from form
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch appointments within the specified date range
    $select_appointments = $conn->prepare("SELECT * FROM `appointments` WHERE appointment_date BETWEEN ? AND ?");
    $select_appointments->execute([$start_date, $end_date]);
    $appointments = $select_appointments->fetchAll(PDO::FETCH_ASSOC);
} else {
    $appointments = array(); // Initialize empty array if no date range is specified
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="admin_style.css">
    <link rel="stylesheet" href="style.css">

    <style>
        /* Table styling */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
        }

        .report-table th, .report-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 18px; /* Increase font size */
            color: black;
        }

        .report-table th {
            background-color: black;
            color: white;
        }

        /* Search bar styling */
        .search-bar {
            position: absolute;
            top: 130px;
            right: 20px;
        }

        .search-bar input[type="text"] {
            width: calc(100% - 40px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: black; /* Set background color to black */
        color: white; /* Set font color to white */
        }

        .search-bar button {
            background-color: black;
            color: white;
            border: none;
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            height: 100%;
            cursor: pointer;

        }
        .search-bar button i {
        color: white; /* Set font color of search icon to white */
        background-color: black;
    }
    .search-bar input[type="text"]::placeholder {
        color: white; /* Set placeholder text color to white */
    }
        /* Form styling */
        .report-form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            
        }

        .report-form {
            background-color: white;
            border: 2px solid black;
            border-radius: 8px;
            padding: 20px;
            max-width: 400px;
            width: 100%;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .report-form label {
            font-weight: bold;
            color: white;
        }

        .report-form input[type="date"]
         {
            font-weight: bold;
            background-color:white;
            width: 100%;
            padding: 10px;
            border: 1px solid black;
            border-radius: 4px;
            margin-bottom: 10px;
            color: black;
        }
        .report-form input[type="submit"]{
            font-weight: bold;
            background-color:black;
            width: 100%;
            padding: 10px;
            border: 1px solid black;
            border-radius: 4px;
            margin-bottom: 10px;
            color: white;
        }
    </style>
</head>
<body>

<?php include 'admin_header.php'; ?>

<section class="contacts">
    <h1 class="heading">View Reports</h1>

    <div class="report-form-container">
        <div class="report-form">
            <form method="post">
                <label for="start_date">From:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date">To:</label>
                <input type="date" id="end_date" name="end_date" required>

                <input type="submit" name="submit" value="Generate Report">
            </form>
        </div>
    </div>

    <div class="search-bar">
        <input type="text" id="appointment_search" placeholder="Search Appointment">
        <button><i class="fas fa-search"></i></button>
    </div>

    <?php if (!empty($appointments)) : ?>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Slot</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment) : ?>
                    <tr>
                        <td><?php echo $appointment['id']; ?></td>
                        <td><?php echo $appointment['name']; ?></td>
                        <td><?php echo $appointment['appointment_date']; ?></td>
                        <td><?php echo $appointment['appointment_slot']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Include SweetAlert library -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<!-- JavaScript for SweetAlert confirmation -->
<script>
    // Add event listener to delete buttons
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

    // Search functionality
    $('#appointment_search').on('input', function() {
        const searchText = $(this).val().toLowerCase();
        $('table.report-table tbody tr').each(function() {
            const appointmentName = $(this).find('td:nth-child(2)').text().toLowerCase();
            if (appointmentName.includes(searchText)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
</script>

</body>
</html>
