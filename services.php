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
    <title>Services Page</title>
    <link rel="stylesheet" href="style.css">  
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
  <div class="sercard">
<div class="card100">
<div class="card-image">
  <img src="img/ser/2.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Central &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Oxygen &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Supply</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
  <img src="img/ser/9.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbspSlit Lamp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/ser/1.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title"> 2D ECHO and Colour Doppler</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/ser/3.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp Trade Mill Test &nbsp;&nbsp;&nbsp;&nbsp;</p>
  </div>
</div>
</div>

<div class="sercard">
<div class="card100">
<div class="card-image">
  <img src="img/ser/4.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp Defibrillator &nbsp;&nbsp;&nbsp;&nbsp;&nbsp</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
  <img src="img/ser/5.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;Pathology &nbsp;&nbsp;&nbsp;&nbsp;Services</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/ser/6.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;X-Ray &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Facility </p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/ser/7.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diabetes &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clinic</p>
  </div>
</div>
</div>

<div class="sercard">
<div class="card100">
<div class="card-image">
  <img src="img/ser/8.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;Life-Style &nbsp;&nbsp;&nbsp;Counselling </p>
  </div>
</div>

<div class="card100">
<div class="card-image">
  <img src="img/ser/12.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;Glaucoma &nbsp;&nbsp;&nbsp;Management</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/ser/13.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cataract &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Surgery</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/ser/10.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Auto &nbsp;Refractokerato &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;meter</p>
  </div>
</div>
</div>
</body>
</html>
<?php include 'footer.php'; ?>