<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit();
}

$message = ["success" => false]; // Initialize a message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $doctor = $_POST["doctor"];
    $doctorRating = $_POST["doctor-rating"];
    $feedback = $_POST["feedback"];

    try {
        $stmt = $conn->prepare("INSERT INTO feedback_data (name, email, doctor, doctor_rating, feedback) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $doctor);
        $stmt->bindParam(4, $doctorRating);
        $stmt->bindParam(5, $feedback);
        $stmt->execute();

        // Set success message
        $message["success"] = true;
    } catch (PDOException $e) {
        // Set error message
        $message["error"] = 'Error!';
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($message);
    exit();
}
?>


<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .container {
            justify-content: center;
            background-color: #afd7d8;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 115px;
            width: 500px;
            margin: 0 auto;
            margin-top: 10px;
            height: 750px;
        }

        input[type="text"],
        input[type="email"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 33px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        h1 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
         
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        .rating {
            display: flex;
            justify-content: center;
            border: none;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 34px;
            cursor: pointer;
            color: #ddd;
            transition: color 0.5s;
        }

        .rating input:checked~label,
        .rating input:hover~label,
        .rating label:hover,
        .rating label:hover~label {
            color: gold;
        }

        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 33px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 33px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        button {
            font-size: 22px;
            background-color: #cdfefe;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 33px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #7db3b3;
        }
    </style>
</head>

<body>
    <div class="container">
        

        <form id="feedback-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h1 style="letter-spacing:2px;"><u>Feedback Form</u></h1>
            <div class="form-group">
                <label for="name">Your Name</label>
                <input type="text" id="name" name="name" required placeholder="Enter Name Of The Patient">
            </div>
            <div class="form-group">
                <label for="email">Your Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter The E-mail ID">
            </div>
            <div class="form-group">
                <label for="doctor">Doctor Visited</label>
                <select id="doctor" name="doctor" required>
                    <option value="" disabled selected>Select Doctor</option>
                    <option value="Dr. Mahesh Gandhi">Dr. Mahesh Gandhi</option>
                    <option value="Dr. Suchita Gandhi">Dr. Suchita Gandhi</option>
                    <!-- Add more doctors as needed -->
                </select>
            </div>
            <div class="form-group">
                <label for="doctor-rating">Rate the Doctor:</label>
                <fieldset class="rating">
                    <input type="radio" id="doc-star5" name="doctor-rating" value="5">
                    <label for="doc-star5" class="star">&#9733;</label>
                    <input type="radio" id="doc-star4" name="doctor-rating" value="4">
                    <label for="doc-star4" class="star">&#9733;</label>
                    <input type="radio" id="doc-star3" name="doctor-rating" value="3">
                    <label for="doc-star3" class="star">&#9733;</label>
                    <input type="radio" id="doc-star2" name="doctor-rating" value="2">
                    <label for="doc-star2" class="star">&#9733;</label>
                    <input type="radio" id="doc-star1" name="doctor-rating" value="1">
                    <label for="doc-star1" class="star">&#9733;</label>
                </fieldset>
            </div>
            <div class="form-group">
                <label for="feedback">Your Feedback:</label>
                <textarea id="feedback" name="feedback" rows="5"></textarea>
            </div>
            <button type="submit" id="submit">Submit Feedback</button>
        </form>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('feedback-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Feedback submitted successfully!',
                            confirmButtonText: 'Close'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.reset();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Feedback submission failed. Please try again later.',
                            confirmButtonText: 'Close'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again later.',
                        confirmButtonText: 'Close'
                    });
                });
        });
    </script>
</body>

</html>
<?php include 'footer.php'; ?>
