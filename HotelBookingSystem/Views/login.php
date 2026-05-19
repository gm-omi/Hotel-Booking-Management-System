<?php



session_start();

$emailError =
$_SESSION['emailError'] ?? "";

$passwordError =
$_SESSION['passwordError'] ?? "";

unset($_SESSION['emailError']);
unset($_SESSION['passwordError']);

?>

<!DOCTYPE html>

<html>

<head>

<title>

Login

</title>

<link
rel="stylesheet"
href="../CSS/task3.css">

</head>

<body>

<div class="auth-container">

<div class="auth-card">

<h2 class="page-title">

Login

</h2>



<form
method="POST"
action="../Controller/AuthController.php">

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

<input
type="checkbox"
name="remember_me">

Remember Me

</label>

</div>



<input
type="hidden"
name="action"
value="login">



<button
type="submit"
class="simple-btn">

Login

</button>

</form>



<p class="auth-link">

Don't have account?

<a href="register.php">

Register

</a>

</p>

</div>

</div>

</body>

</html>