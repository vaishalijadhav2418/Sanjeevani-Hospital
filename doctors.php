<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};


?><?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Doctors</title>
 <link rel="stylesheet" href="style.css">
 <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
  <div class="docard">
<div class="card-container">
  <div class="card99">
  <div class="front-content">
  <img src="img/hsp/11.jpg" alt="Image 1" width="395px" height="470px">
  </div>
  <div class="content">
    <p class="heading">Dr. Mahesh Gandhi</p>
    <p>
  M.B.B.S (GOLD MEDALIST), M.D. (MEDICINE)
</p>
  </div>
</div>
</div>
<div class="card-container">
  <div class="card99">
  <div class="front-content">
 <img src="img/hsp/10.jpg" alt="Image 2" width="395px" height="320px">
  </div>
  <div class="content">
    <p class="heading">Dr. Suchita Gandhi</p>
    <p>
     D.O.M.S(MUMBAI)
    </p>
  </div>
</div>
</div>

</div>
<div class="butt">
<button class="continue-application1">
    <div>
        <div class="pencil" ></div>
        <div class="folder">
            <div class="top">
                <svg viewBox="0 0 24 27">
                    <path d="M1,0 L23,0 C23.5522847,-1.01453063e-16 24,0.44771525 24,1 L24,8.17157288 C24,8.70200585 23.7892863,9.21071368 23.4142136,9.58578644 L20.5857864,12.4142136 C20.2107137,12.7892863 20,13.2979941 20,13.8284271 L20,26 C20,26.5522847 19.5522847,27 19,27 L1,27 C0.44771525,27 6.76353751e-17,26.5522847 0,26 L0,1 C-6.76353751e-17,0.44771525 0.44771525,1.01453063e-16 1,0 Z"></path>
                </svg>
            </div>
            <div class="paper"></div>
        </div>
    </div>
   <a href="appointment.php" style="color:white;"> Book Appointment </a>
</button>
</div>
<div class="space">
</div>
</body>
</html>
<?php include 'footer.php'; ?>