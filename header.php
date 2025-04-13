<?php
if (session_status() == PHP_SESSION_NONE) {
    // Check if the session is not already started
    session_start();
}

// Check if the user_id is set in the session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Fetch user's name from the database
$user_name = "";
if ($user_id) {
    // Replace 'your_database_connection' with your actual database connection
    include 'connect.php';

    $select_user = $conn->prepare("SELECT name FROM `users` WHERE id = ?");
    $select_user->execute([$user_id]);
    $user_data = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($user_data) {
        $user_name = $user_data['name'];
    }
}
?>
<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<section id="header">
    <nav>
        <div class="nevbar">
            <img src="img/hsp/2.png" class="img">
            <h4> SANJEEVANI HOSPITAL</h4>
        </div>

        <ul class="nav-link">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="doctors.php">Doctors</a></li>
            <li><a href="rooms.php">Rooms</a></li>
            <li><a href="contact.php">Contact Us</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="chat.php">Chat</a></li>
            <li>
                <?php if ($user_id): ?>
                    <li class="profile">
                        <span id="welcome-text">Welcome, <?php echo $user_name; ?></span>
                        <div class="dropdown" id="dropdown">
                            <a href="view_booking.php">View Booking</a>
                            <a href="change_password.php">Change Password</a> <!-- Added Change Password link -->
                            <a href="user_logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <a href="login.php">
                        <i class='bx bx-user-circle'></i>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</section>
