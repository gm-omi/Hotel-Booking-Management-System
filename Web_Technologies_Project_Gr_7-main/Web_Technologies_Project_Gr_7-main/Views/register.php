<?php

session_start();

$nameError = $_SESSION['nameError'] ?? "";
$emailError = $_SESSION['emailError'] ?? "";
$passwordError = $_SESSION['passwordError'] ?? "";
$phoneError = $_SESSION['phoneError'] ?? "";
$nationalityError = $_SESSION['nationalityError'] ?? "";

unset($_SESSION['nameError']);
unset($_SESSION['emailError']);
unset($_SESSION['passwordError']);
unset($_SESSION['phoneError']);
unset($_SESSION['nationalityError']);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Register</title>

</head>

<body>

<form method="POST" action="../Controller/AuthController.php">

<table>

<tr>
    <td>Name</td>

    <td>
        <input type="text" name="name">
    </td>

    <td style="color:red">
        <?php echo $nameError; ?>
    </td>
</tr>

<tr>
    <td>Email</td>

    <td>
        <input type="email" name="email">
    </td>

    <td style="color:red">
        <?php echo $emailError; ?>
    </td>
</tr>

<tr>
    <td>Password</td>

    <td>
        <input type="password" name="password">
    </td>

    <td style="color:red">
        <?php echo $passwordError; ?>
    </td>
</tr>

<tr>
    <td>Phone</td>

    <td>
        <input type="text" name="phone">
    </td>

    <td style="color:red">
        <?php echo $phoneError; ?>
    </td>
</tr>

<tr>
    <td>Nationality</td>

    <td>
        <input type="text" name="nationality">
    </td>

    <td style="color:red">
        <?php echo $nationalityError; ?>
    </td>
</tr>

<tr>
    <td>
        <input type="hidden" name="action" value="register">

        <input type="submit" value="Register">
    </td>
</tr>

<tr>
    <td>Already have account?</td>

    <td>
        <a href="login.php">Login</a>
    </td>
</tr>

</table>

</form>

</body>

</html>