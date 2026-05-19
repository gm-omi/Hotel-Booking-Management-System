<?php

include "../Includes/auth.php";

include "../Includes/navbar.php";

include "../Includes/sidebar.php";

include "../Config/DatabaseCon.php";

include "../Model/UserModel.php";

$db = new DatabaseCon();

$connection = $db->openCon();

$userModel = new UserModel();

$userId = $_SESSION['user_id'];

$result =
$userModel->getUserById(
    $connection,
    $userId
);

$user =
$result->fetch_assoc();

?>

<!DOCTYPE html>

<html>

<head>

<title>

My Profile

</title>

<link
rel="stylesheet"
href="../CSS/task3.css">

</head>

<body>

<div class="content">

<div class="profile-container">

<h2 class="page-title">

My Profile

</h2>



<div class="profile-card">

<div class="profile-row">

<label>

Name

</label>

<p>

<?php echo $user['name']; ?>

</p>

</div>



<div class="profile-row">

<label>

Email

</label>

<p>

<?php echo $user['email']; ?>

</p>

</div>



<div class="profile-row">

<label>

Phone

</label>

<p>

<?php echo $user['phone']; ?>

</p>

</div>



<div class="profile-row">

<label>

Role

</label>

<p>

<?php echo $user['role']; ?>

</p>

</div>



<a href="updateProfile.php">

<button class="simple-btn">

Update Profile

</button>

</a>

</div>

</div>

</div>

</body>

</html>