<?php
include 'connect.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if the user is not logged in and redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Ensure that the script stops execution after redirection
}

$user_id = $_SESSION['user_id'];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submission
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $doctor = $_POST['doctor'];
    $firstVisit = $_POST['first-visit'];
    $selectedDate = $_POST['date'];
    $selectedSlot = $_POST['slot'];

    // Add your validation and sanitization here

    // Insert appointment data into the database
    $queryInsert = "INSERT INTO appointments (user_id, name, phone, email, doctor, first_visit, appointment_date, appointment_slot) 
              VALUES (:user_id, :name, :phone, :email, :doctor, :first_visit, :appointment_date, :appointment_slot)";

    $stmtInsert = $conn->prepare($queryInsert);

    // Bind parameters for insert query
    $stmtInsert->bindParam(':user_id', $user_id);
    $stmtInsert->bindParam(':name', $name);
    $stmtInsert->bindParam(':phone', $phone);
    $stmtInsert->bindParam(':email', $email);
    $stmtInsert->bindParam(':doctor', $doctor);
    $stmtInsert->bindParam(':first_visit', $firstVisit);
    $stmtInsert->bindParam(':appointment_date', $selectedDate);
    $stmtInsert->bindParam(':appointment_slot', $selectedSlot);

    $resultInsert = $stmtInsert->execute();

    if ($resultInsert) {
        // Appointment successfully added

        // Decrease the available slot count by 1
        $queryUpdate = "UPDATE slots SET quantity = quantity - 1 WHERE date = :selectedDate AND slot = :selectedSlot";
        $stmtUpdate = $conn->prepare($queryUpdate);

        // Bind parameters for update query
        $stmtUpdate->bindParam(':selectedDate', $selectedDate);
        $stmtUpdate->bindParam(':selectedSlot', $selectedSlot);

        $stmtUpdate->execute();

        // Set success message
        $successMessage = "Appointment Booked successfully!";
    } else {
        // Error in adding appointment
        $errorMessage = "Error submitting appointment. Please try again.";
    }
}

// Function to get available slots and their quantities for the selected date
function getAvailableSlotsWithQty($selectedDate)
{
    global $conn; // Make the database connection global
    // Replace 'your_slots_table' and 'quantity_field' with your actual table and quantity field names.
    $query = "SELECT slot, quantity FROM slots WHERE date = :selectedDate";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':selectedDate', $selectedDate);
    $stmt->execute();

    $availableSlots = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $availableSlots[$row['slot']] = $row['quantity'];
    }

    return $availableSlots;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>

<?php if (!empty($successMessage)): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Appointment Submitted',
            text: '<?php echo $successMessage; ?>',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'Appointment.php'; // Redirect to the home page or any other page
            }
        });
    </script>
<?php else: ?>

<form method="POST" action="">
    <!-- Your form fields here -->
    <input type="submit" value="Submit Appointment">
</form>

<?php endif; ?>

</body>
</html>