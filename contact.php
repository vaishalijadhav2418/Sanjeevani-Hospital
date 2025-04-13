<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.php';
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];

        // Use prepared statements to prevent SQL injection
        $sql = "INSERT INTO contacts (full_name, email, subject) VALUES (:full_name, :email, :subject)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':subject', $subject);

        try {
            $stmt->execute();
            // Display SweetAlert for successful submission
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire('Success', 'Message Sent!', 'success');
                    });
                  </script>";
            // You can redirect the user to a thank you page or perform other actions.
        } catch (PDOException $e) {
            // Handle errors if needed
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire('Error', 'An error occurred!', 'error');
                    });
                  </script>";
        }
    }
} else {
    // Redirect the user to the login page or display a message prompting them to log in
    header("Location: login.php"); // Change 'login.php' to your actual login page
    exit();
}
?>

<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="style.css"> 
  
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            margin: 0;
           
        }

        .icon {
            display: flex;
            justify-content: center;
            font-size: 25px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 0 0 35px 35px;
        }

        .con {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .wrapper {
            display: flex;
            gap: 10px;
        }

        .card97 {
            width: 450px;
            height: 520px;
            background-color: #afd7d8;
            box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
            padding: 20px;
            border-radius: 35px;
        }

        .column form {
            display: flex;
            flex-direction: column;
            
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            margin-bottom: 16px;
            border-radius: 35px;
        }

        input[type="submit"] {
            font-weight: bold;
            background-color: #cdfefe;
            color: black;
            padding: 12px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 35px;
        }

        input[type="submit"]:hover {
            background-color: #7db3b3;
        }

        .card {
            position: relative;
            width: 600px;
            height: 450px;
            overflow: hidden;
            border-radius: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card:hover .map-heading {
            opacity: 2;
        }

        .map-heading {
            position: absolute;
            top: 10px;
            left: 20px;
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            z-index: 1; /* Ensure the heading appears above the iframe */
        }

        .card iframe {
            width: 100%;
            height: 100%;
            border: 0;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="icon">
        <i class='bx bxs-map' style='color:#45b6fe'></i>
        &nbsp; Ramdas Peth, Near Tilak Park, Opposite Post Office, Akola.
        <br>
        <i class='bx bx-phone' style='color:#45b6fe'></i>
        &nbsp; (H)-0724 2411728 (A)-8380902749
    </div>

    <div class="con">
        <div class="wrapper">
            <div class="card97">
                <div class="column">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <h1><b><u>Contact-Us</u></b></h1>
                        <label for="fname">Full Name</label>
                        <input type="text" id="fname" name="full_name" placeholder="Enter Your Full Name.." required>
                        <label for="mail">E-mail</label>
                        <input type="email" id="lname" name="email" placeholder="Enter Your Email ID.." required>
                        <label for="subject">Subject</label>
                        <textarea id="subject" name="subject" placeholder="Write something.." style="height:170px" required></textarea>
                        <input type="submit" value="Submit">
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="map-heading">Location</div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3731.7527840282314!2d77.00564807470629!3d20.720261098303983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bd731df055b563f%3A0xcfb6de0ea99b7acb!2sSanjeevani%20Hospital!5e0!3m2!1sen!2sin!4v1708190614512!5m2!1sen!2sin"
                    style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</body>
</html>

<?php include 'footer.php'; ?>