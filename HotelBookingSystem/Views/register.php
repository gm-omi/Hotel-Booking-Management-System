<?php

session_start();

$nameError =
$_SESSION['nameError'] ?? "";

$emailError =
$_SESSION['emailError'] ?? "";

$passwordError =
$_SESSION['passwordError'] ?? "";

$phoneError =
$_SESSION['phoneError'] ?? "";

$nationalityError =
$_SESSION['nationalityError'] ?? "";

unset($_SESSION['nameError']);
unset($_SESSION['emailError']);
unset($_SESSION['passwordError']);
unset($_SESSION['phoneError']);
unset($_SESSION['nationalityError']);

?>

<!DOCTYPE html>

<html>

<head>

<title>

Register

</title>

<link
rel="stylesheet"
href="../CSS/task3.css">

</head>

<body>

<div class="auth-container">

<div class="auth-card">

<h2 class="page-title">

Register

</h2>



<form
method="POST"
action="../Controller/AuthController.php">

<div class="form-group">

<label>

Name

</label>

<input
type="text"
name="name"
class="form-input">

<p class="error-text">

<?php echo $nameError; ?>

</p>

</div>



<div class="form-group">

<label>

Email

</label>

<input
type="email"
name="email"
class="form-input">

<p class="error-text">

<?php echo $emailError; ?>

</p>

</div>



<div class="form-group">

<label>

Password

</label>

<input
type="password"
name="password"
class="form-input">

<p class="error-text">

<?php echo $passwordError; ?>

</p>

</div>



<div class="form-group">

<label>

Phone

</label>

<input
type="text"
name="phone"
class="form-input">

<p class="error-text">

<?php echo $phoneError; ?>

</p>

</div>



<div class="form-group">

<label>

Nationality

</label>

<input
type="text"
name="nationality"
class="form-input">

<p class="error-text">

<?php echo $nationalityError; ?>

</p>

</div>



<input
type="hidden"
name="action"
value="register">



<button
type="submit"
class="simple-btn">

Register

</button>

</form>



<p class="auth-link">

Already have account?

<a href="login.php">

Login

</a>

</p>

</div>

</div>

</body>

</html>