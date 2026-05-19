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

Update Profile

</title>

<link
rel="stylesheet"
href="../CSS/task3.css">

</head>

<body>

<div class="content">

<div class="profile-container">

<h2 class="page-title">

Update Profile

</h2>



<form
action="../Controller/profileController.php"
method="POST"
class="profile-form">

<input
type="hidden"
name="id"
value="<?php echo $user['id']; ?>">



<div class="form-group">

<label>

Name

</label>

<input
type="text"
name="name"
class="form-input"
value="<?php echo $user['name']; ?>"
required>

</div>



<div class="form-group">

<label>

Email

</label>

<input
type="email"
name="email"
class="form-input"
value="<?php echo $user['email']; ?>"
required>

</div>



<div class="form-group">

<label>

Phone

</label>

<input
type="text"
name="phone"
class="form-input"
value="<?php echo $user['phone']; ?>"
required>

</div>



<div class="form-group">

<label>

New Password
(Optional)

</label>

<input
type="password"
name="password"
class="form-input">

</div>



<button
type="submit"
class="simple-btn">

Update Profile

</button>

</form>

</div>

</div>

</body>

</html>