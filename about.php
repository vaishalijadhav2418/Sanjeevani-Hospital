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
    <title>About-us Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="abv">
<div class="card2">
    <img src="img/hsp/11.jpg" alt="Image 1" height="650px" width="580px">
</div>
<div class="card5">
  <div class="card5-content">
   
    <span>Welcome to Sanjeevani hospital!! </span> 
<p>We're dedicated to providing exceptional healthcare services with a focus on patient-centered care, cutting-edge medical technology, and community engagement.
<p>We Founded on the principles of compassion and innovation, our hospital has been serving the community for 15 years. Since our inception, we've continuously evolved to meet the changing needs of our patients and the advancements in medical science.
<p>Our Mission: 
Our mission is to improve the health and well-being of our community by delivering outstanding patient care, conducting groundbreaking research, and educating the next generation of healthcare professionals.
<p>Our Values: 
At the heart of everything we do our core values of compassion, integrity, excellence, and teamwork. These values guide our interactions with patients, families, and each other, ensuring that every individual receives the highest standard of care.
<p>Thank you for taking the time to learn more about us. We're honored to be your healthcare provider and look forward to serving you with compassion, excellence, and dedication.
</p>
</p>
</p>
</p>
</p>

</div>
</div>
</div>
</body>
</html>
<?php include 'footer.php'; ?>
