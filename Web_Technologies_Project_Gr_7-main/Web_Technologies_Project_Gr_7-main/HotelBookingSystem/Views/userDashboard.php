<?php


include "../Includes/auth.php";
include "../Includes/navbar.php";

include "../Includes/sidebar.php";

?>

<!DOCTYPE html>
<html>

<head>

    <title>User Dashboard</title>

</head>

<body>

<h2>

    Welcome User

</h2>

<p>

    Name:
    <?php echo $_SESSION['name']; ?>

</p>

<p>

    Role:
    <?php echo $_SESSION['role']; ?>

</p>

<p>

    User ID:
    <?php echo $_SESSION['user_id']; ?>

</p>

<a href="../Controller/logout.php">

    Logout

</a>

</body>

</body>

</html>