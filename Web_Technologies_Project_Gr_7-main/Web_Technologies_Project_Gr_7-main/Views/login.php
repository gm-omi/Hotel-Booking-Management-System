<?php

session_start();

$emailError = $_SESSION['emailError'] ?? "";
$passwordError = $_SESSION['passwordError'] ?? "";

unset($_SESSION['emailError']);
unset($_SESSION['passwordError']);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Login</title>

</head>

<body>

<form method="POST" action="../Controller/AuthController.php">

<table>

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
    <td>Remember Me</td>

    <td>
        <input type="checkbox" name="remember_me">
    </td>
</tr>

<tr>
    <td>
        <input type="hidden" name="action" value="login">

        <input type="submit" value="Login">
    </td>
</tr>

<tr>
    <td>Don't have account?</td>

    <td>
        <a href="register.php">Register</a>
    </td>
</tr>

</table>

</form>

</body>

</html>