<?php
if (session_status() == PHP_SESSION_NONE) {
    // Check if the session is not already started
    session_start();
}

// Check if the admin_id is set in the session
$admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : null;

// Fetch admin's name from the database
$admin_name = "";
if ($admin_id) {
    // Replace 'your_database_connection' with your actual database connection
    include 'connect.php';

    $select_admin = $conn->prepare("SELECT name FROM `admin_users` WHERE id = ?");
    $select_admin->execute([$admin_id]);
    $admin_data = $select_admin->fetch(PDO::FETCH_ASSOC);

    if ($admin_data) {
        $admin_name = $admin_data['name'];
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
            <img src="../img/hsp/2.png" class="img">
            <h4>ADMIN PANEL</h4>
        </div>
        
        <ul class="nav-link">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="show_users.php">Users</a></li>
            <li><a href="addslot.php">Add Slot</a></li>
            <li><a href="show_slots.php">View Slot</a></li>
            <li><a href="show_appointments.php">Appointments</a></li>
            <li><a href="showcontact_messages.php">Messages</a></li>
            <li><a href="show_feedback.php">Feedback</a></li>
            <li><a href="viewchatbotmessage.php">Chat</a></li>
            <li><a href="viewreports.php">Reports</a></li>
            <li>
                <?php if ($admin_id): ?>
                    <li class="profile">
                        <span id="welcome-text">Welcome, <?php echo $admin_name; ?></span>
                        <div class="dropdown" id="dropdown">
                        <a href="changepassword.php">Change Password</a>
                            <a href="admin_logout.php">Logout</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="admin_login.php">
                            <i class='bx bx-user-circle'></i>
                        </a>
                    </li>
                <?php endif; ?>
            </li>
        </ul>
    </nav>
</section>
