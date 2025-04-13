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
    <title>Room Page</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<style>


</style>


</head>
<body>
<div class="slides-container">

<div class="slider">
  <div class="slide"><img src="img/room/1.jpg" alt="Image 1" ></div>
  <div class="slide"><img src="img/room/2.jpg" alt="Image 2" ></div>
  <div class="slide"><img src="img/room/3.jpg" alt="Image 3" ></div>
  <div class="slide"><img src="img/room/4.jpg" alt="Image 4" ></div>
  
</div>

<div class="dots-container">
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>
  <span class="dot"></span>

</div>
<button class="prev-button">&lt; </button>
<button class="next-button"> &gt;</button>
</div>
<div class="sercard">
<div class="card100">
<div class="card-image">
  <img src="img/room/5.jpg " width="190px" height="255px">
</div>
<div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp H.D.U. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp Room</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
  <img src="img/room/6.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp; Delux Room &nbsp;&nbsp;&nbsp;</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/room/10.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp Special Room &nbsp</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/room/7.jpg  " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;Twin Sharing &nbsp;&nbsp;&nbsp;&nbsp (Non A/C)&nbsp;&nbsp;&nbsp;</p>
  </div>
</div>
</div>

<div class="sercard">
<div class="card100">
<div class="card-image">
  <img src="img/room/6.jpg  " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title"> &nbsp;&nbsp;&nbsp;Twin Sharing &nbsp;&nbsp;&nbsp;&nbsp(Separate)</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
  <img src="img/room/2.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">&nbsp;&nbsp;&nbsp;Twin Sharing &nbsp;&nbsp(A/C Separate)</p>
  </div>
</div>

<div class="card100">
<div class="card-image">
<img src="img/room/5.jpg " width="190px" height="255px">
</div>
  <div class="card-description">
    <p class="text-title">Economy Ward &nbsp</p>
  </div>
</div>
</div>


</div>

<script src="script.js"></script>
</body>
</html>
<?php include 'footer.php'; ?>