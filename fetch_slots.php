<?php

// Include the database connection file
include 'connect.php';

// Get the selected date from the AJAX request
$selectedDate = $_POST['date'];

try {
    // Validate the selected date format (assuming Y-m-d for simplicity)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)) {
        throw new InvalidArgumentException('Invalid date format');
    }

    // Prepare the SQL query to fetch available slots and their quantities from the database
    $sql = "SELECT slot, quantity FROM slots WHERE date = :selectedDate";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Fetch the results
    $availableSlots = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $availableSlots[$row['slot']] = $row['quantity'];
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($availableSlots);
} catch (PDOException $e) {
    // Handle database connection or query errors
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => $e->getMessage()]);
    exit();
} catch (InvalidArgumentException $e) {
    // Handle invalid date format
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}

?>