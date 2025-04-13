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


// Function to get available slots and their quantities for the selected date
function getAvailableSlotsWithQty($selectedDate)
{
    global $conn; // Make the database connection global
    // Replace 'your_slots_table' and 'quantity_field' with your actual table and quantity field names.
    $query = "SELECT slot, quantity FROM slots WHERE date = '$selectedDate'";
    $result = mysqli_query($conn, $query);

    $availableSlots = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $availableSlots[$row['slot']] = $row['quantity'];
    }

    return $availableSlots;
}

?>

<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Request Appointment</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #afd7d8;
            width: 500px;
            margin: 50px auto;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 35px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 43px;
        }

        .radio-buttons {
            display: flex;
            align-items: center;
        }

        .radio-buttons input {
            margin-right: 10px;
        }

        button {
            font-size:20px;
            font-weight: bold;
            background-color: #cdfefe;
            color: black;
            padding: 20px 30px;
            border: none;
            border-radius: 35px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color:  #7db3b3;
        }

        /* Style for available and unavailable slots */
        .slot {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            cursor: pointer;
        }

        .slot.available {
            background-color: #8BC34A; /* Green for available slots */
        }

        .slot.unavailable {
            background-color: #FF5252; /* Red for unavailable slots */
            pointer-events: none; /* Disable clicking on unavailable slots */
        }

        #slot-quantity {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        
        <form id="appointment-form" action="submit_form.php" method="POST">
        <h1 style="letter-spacing:2px;">Request an Appointment</h1>    
        <div class="form-group">
                <label for="name">Name of Patient</label>
                <input type="text" id="name" name="name" required placeholder="Enter The Name Of Patient">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required placeholder="Enter The Phone Number">
            </div>
            <div class="form-group">
                <label for="email">E-mail ID</label>
                <input type="email" id="email" name="email" required placeholder="Enter The E-mail ID">
            </div>
            <div class="form-group">
                <label for="doctor">Select Doctor</label>
                <select id="doctor" name="doctor" required>
                    <option value="Dr.Mahesh Gandhi">Dr.Mahesh Gandhi</option>
                    <option value="Dr.Suchita Gandhi">Dr.Suchita Gandhi</option>
                </select>
            </div>
            <div class="form-group">
                <label for="first-visit">First Time Visit?</label>
                <div class="radio-buttons">
    <input type="radio" id="yes" name="first-visit" value="yes" required>
    <label for="yes">Yes</label>
    <input type="radio" id="no" name="first-visit" value="no" required>
    <label for="no">No</label>
</div>
            </div>
            <div class="form-group">
                <label for="date">Select an Appointment Date</label>
                <?php
                // Calculate the current date and format it in the required format (Y-m-d)
                $currentDate = date('Y-m-d');
                ?>
                <input type="date" id="date" name="date" required min="<?php echo $currentDate; ?>">
            </div>

            <!-- Display available slots based on the selected date -->
            <div class="form-group">
                <label for="slot">Select a Slot</label>
                <select id="slot" name="slot" required >
                    <!-- Slots will be dynamically loaded here -->
                </select>
            </div>

            <!-- Add the slot quantity display element -->
            <div id="slot-quantity"></div>

            <button type="submit">Submit Form</button>
        </form>
    </div>

    <script>
        const form = document.getElementById('appointment-form');
const dateInput = document.getElementById('date');
const slotSelect = document.getElementById('slot');
let data = {}; // Declare data globally

dateInput.addEventListener('input', loadAvailableSlots);
slotSelect.addEventListener('change', updateSlotQuantity);

function loadAvailableSlots() {
    const selectedDate = dateInput.value;
    fetchAvailableSlots(selectedDate);
}

function updateSlotQuantity() {
    const selectedSlot = slotSelect.value;
    const slotQuantity = data[selectedSlot];
    
    if (typeof slotQuantity !== 'undefined') {
        document.getElementById('slot-quantity').innerHTML = `Slots available: ${slotQuantity}`;
    } else {
        console.error('Error: Slot quantity not defined for selected slot.');
    }
}

function fetchAvailableSlots(selectedDate) {
    const endpoint = 'fetch_slots.php';
    const formData = new FormData();
    formData.append('date', selectedDate);

    fetch(endpoint, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(dataResponse => {
        // Assign the received data to the global variable
        data = dataResponse;

        slotSelect.innerHTML = '';

        for (const slot in data) {
            const option = document.createElement('option');
            option.value = slot;
            option.textContent = `${slot} (${data[slot]} slots available)`;

            option.classList.add(data[slot] > 0 ? 'available' : 'unavailable');
            option.disabled = data[slot] === 0;

            slotSelect.appendChild(option);
        }

        updateSlotQuantity(); // Call this function to update slot quantity on initial load
    })
    .catch(error => console.error('Error fetching available slots:', error));
}
    </script>



</body>

</html>
<?php include 'footer.php'; ?>