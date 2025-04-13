<?php
include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
?>
<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>   
    <link rel="stylesheet" href="header.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="img/hsp/2.png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
        /* Add this style to your existing CSS */
        /* Style the button */

        .scroll-to-top-btn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #000;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 50%;
        }
        .scroll-to-top-btn i {
            font-size: 20px;
        }

        .book-appointment {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background-color: transparent;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .book-appointment p {
            margin: 0 0 5px;
            color: white;
            font-size: 20px;
        }

        .appointment-button {
            padding: 8px 16px;
            background-color: lightgreen;
            color: black;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .appointment-button:hover {
            background-color: white;
        }

        /* Action Section */
        .action-section {
    text-align: center;
    background-color: #00807a;
    color: #fff;
    padding: 30px 0;
}

.action-heading {
    font-size: 28px; /* Increase the font size of the heading */
    margin-bottom: 35px; /* Add some spacing between the heading and the action cards */
}

.action-card {
    background-color: white;
    color: #fff;
    padding: 20px;
    margin: 0 10px;
    border-radius: 10px;
    max-width: 500px; /* Set max-width instead of fixed width */
    
}

.action-cards {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
    overflow-x: auto;
    width: 100%;
}

        .action-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: black;
        }

        .action-card p {
            font-size: 16px;
            margin-bottom: 20px;
            color: black;
            font: bold;
        }

        .action-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: lightgreen;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #7ab4ad;
        }
        /* Responsive styles for action cards */
@media only screen and (min-width: 768px) {
    .action-card {
        width: calc((100% - 40px) / 2); /* Adjust width for larger screens */
    }
}

@media only screen and (min-width: 1200px) {
    .action-card {
        width: calc((100% - 60px) / 3); /* Adjust width for even larger screens */
    }
}
.sidebar {
  position: fixed;
  top: 35%; /* Position the sidebar vertically centered */
  right: -300px; /* Initially hidden */
  width: 250px;
  height: auto;
  background-color: #008489;
  color: #fff;
  transition: right 0.3s ease;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 20px;
  z-index: 9998; /* Ensure the sidebar is below the trigger button */
}

.sidebar-header {
  font-size: 24px;
  margin-bottom: 20px;
}

.sidebar-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

.contact {
  margin-bottom: 10px;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: none;
  border: none;
  color: #fff;
  font-size: 20px;
  cursor: pointer;
}

.sidebar-trigger {
  position: fixed;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  background-color: 008489;
  color: white;
  font-size: 24px;
  font-weight: bold;
  line-height: 1.5;
  padding: 10px;
  text-align: center;
  writing-mode: vertical-lr;
  white-space: nowrap;
  z-index: 9999; /* Ensure the trigger button is above the sidebar */
  cursor: pointer;
}
    .chat-icon {
            position: fixed;
            bottom: 205px;
            right: 0px;
            width: 60px;
            height: 60px;
            background-color: #cce2e4; /* Change color as needed */
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 24px;
            cursor: pointer;
            z-index: 9999; /* Ensure it's above other elements */
        }
        
    </style>
</head>
<body>
  
<div class="slides-container">

  <div class="slider">
    <div class="slide"><img src="img/hsp/1.jpg" alt="Image 1" ></div>
    <div class="slide"><img src="img/hsp/9.jpg" alt="Image 2" ></div>
    <div class="slide"><img src="img/hsp/4.jpg" alt="Image 3" ></div>
    <div class="slide"><img src="img/hsp/5.jpg" alt="Image 4" ></div>
    <div class="slide"><img src="img/hsp/3.jpg" alt="Image 5" ></div>
    <div class="slide"><img src="img/hsp/7.jpg" alt="Image 6" ></div>
    <div class="slide"><img src="img/hsp/8.jpg" alt="Image 7" ></div>
  </div>
  
  <div class="dots-container">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
  <button class="prev-button">&lt; </button>
  <button class="next-button"> &gt;</button>

  <!-- Book Appointment button -->
  <div class="book-appointment">
    <p>Need an Appointment</p>
    <button class="appointment-button">
        <a href="Appointment.php" style="color: inherit; text-decoration: none;">Book Appointment</a>
    </button>
</div>
</div>


<div class="abv">
  <div class="cards">
    <b><p class="card-title">About Us</p></b>
    <p class="small-desc">
    Welcome to Sanjeevani Hospital, where compassionate care meets medical excellence. At Sanjeevani, we are dedicated to providing comprehensive healthcare services with a human touch.
    </p>
    <button class="cta">
      <a href="about.php">
        <span>Learn More</span>
      </a>
      <svg width="15px" height="10px" viewBox="0 0 13 10">
        <path d="M1,5 L11,5"></path>
        <polyline points="8 1 12 5 8 9"></polyline>
      </svg>
    </button>
    <div class="go-corner">
      <div class="go-arrow">→</div>
    </div>
  </div>

  <div class="other-features">
    <h5>Other Features</h5>
    <div class="container">
      <div class="card">
        <img src="img/icon(1).png">
      </div>
      <div class="card">
        <img src="img/icon(2).png">
      </div>
      <div class="card">
        <img src="img/icon(3).png">
      </div>
      <div class="card">
        <img src="img/icon(4).png">
      </div>
      <div class="card">
        <img src="img/icon(5).png">
      </div>
      <div class="card">
        <img src="img/icon(6).png">
      </div>
    </div>
  </div>
</div>

<div class="bgtext">
  <div class="image-container">
    <img src="img/34.jpg" alt="Background Image" class="background-image">
    <div class="text-container">
      <h2>Health, Happiness, and Harmony.</h2>
      <p>Good Health Empowers You. Thrive With Good Health. Health Is An Investment, Not An Expense. Eat Better, Feel Better.</p>
    </div>
  </div>
</div>

<section class="action-section">
        <div>
            <!-- Action Cards -->
            <h3 class="action-heading">What would you like to do today?</h3>
            <div class="action-cards">
                <!-- Card 1: Book Appointment -->
                <div class="action-card">
                    <h3>Book Appointment</h3>
                    <a href="Appointment.php" class="action-btn">Book Now</a>
                </div>
                
                
                <!-- Card 2: Chat with Doctor -->
                <div class="action-card">
                    <h3>Chat with Doctor</h3>
                    <a href="chat.php" class="action-btn">Start Chat</a>
                </div>
                <!-- Card 3: Take Assessment -->
                <div class="action-card">
                    <h3>Take Assessment</h3>
                    <a href="gettingstarted.php" class="action-btn">Take Assessment</a>
                </div>
                <!-- Repeat other action cards as needed -->
            </div>
        </div>
    </section>
    
<div class="main-container1">
<div class="sidebar-trigger">Emergency</div> <!-- Add this element -->
    <div class="card6" id="card1">
        <div class="rating1">
            <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
            </ul>
        </div>
        
        <p class="desc1">Overall service is good. Doctors nurses are very caring and helpful. They supported me throughout the illness process.</p>
        <p class="read-more1">
         
        </p>
    </div>

    <div class="card6" id="card2">
        <div class="rating1">
            <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
            </ul>
        </div>
    
        <p class="desc1">The staff at Sanjeevani Hospital was highly professional, courteous, and knowledgeable. They took the time to listen to my concerns, answer my questions, and provide clear explanations about the treatment process.</p>
        <p class="read-more1">
           
        </p>
    </div>
    <div class="card6" id="card3">
        <div class="rating1">
            <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
            </ul>
        </div>
        <p class="desc1">I was also impressed by the emphasis placed on patient safety and hygiene. The hospital followed strict protocols to maintain a clean and sterile environment, which gave me peace of mind during my treatment.</p>
        <p class="read-more1">
            
        </p>
    </div>

    <div class="card6" id="card3">
        <div class="rating1">
            <ul>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
                <li><i class="fa-solid fa-star"></i></li>
            </ul>
        </div>
        <p class="desc1">I was also impressed by the emphasis placed on patient safety and hygiene. The hospital followed strict protocols to maintain a clean and sterile environment, which gave me peace of mind during my treatment.</p>
        <p class="read-more1">
            
        </p>
    </div>
    
</div>
<div class="chat-icon">
        <a href="chat.php">
            <i class="fas fa-comment"></i> <!-- Change icon as needed -->
        </a>
    </div>
<!-- Scroll to top button -->
<div id="scrollToTopBtn" class="scroll-to-top-btn"><i class="fas fa-chevron-up"></i></div>

<div class="sidebar" id="sidebar">
        <!-- Your existing sidebar content here -->
        <div class="sidebar-header">EMERGENCY</div>
        <div class="sidebar-content">
            <div class="contact">1234567890</div>
            <div class="contact">2345678901</div>
            <div class="contact">3456789012</div>
            <div class="contact">4567890123</div>
            <div class="contact">5678901234</div>
        </div>
        <button class="close-btn" onclick="toggleSidebar()">&times;</button>
    </div>
    <script src="script.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    var sidebar = document.querySelector('.sidebar');
    var closeBtn = document.querySelector('.close-btn');
    var sidebarTrigger = document.querySelector('.sidebar-trigger');

    // Show the button when user scrolls down
    window.onscroll = function() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };

    // Scroll to the top when the button is clicked
    scrollToTopBtn.onclick = function() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    };

    // Open sidebar when clicking on the sidebar trigger
    sidebarTrigger.addEventListener('click', function() {
        sidebar.style.right = '0';
        sidebarTrigger.style.display = 'none'; // Hide the trigger button
    });

    // Close sidebar when clicking on the close button
    closeBtn.addEventListener('click', function() {
        sidebar.style.right = '-300px';
        sidebarTrigger.style.display = 'block'; // Show the trigger button again
    });
});
function toggleSidebar() {
    var sidebar = document.querySelector('.sidebar');
    var sidebarTrigger = document.querySelector('.sidebar-trigger');

    if (sidebar.style.right === '0px') {
        sidebar.style.right = '-300px';
        sidebarTrigger.style.display = 'block';
    } else {
        sidebar.style.right = '0';
        sidebarTrigger.style.display = 'none';
    }
}
</script>

</body>
</html>
<?php include 'footer.php'; ?>
