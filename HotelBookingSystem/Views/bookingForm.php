<?php

include "../Includes/auth.php";

include "../Includes/navbar.php";

include "../Includes/sidebar.php";

include "../Config/DatabaseCon.php";

include "../Model/UserModel.php";

include "../Model/RoomModel.php";

$db = new DatabaseCon();

$connection = $db->openCon();

$userModel = new UserModel();

$roomModel = new RoomModel();

$userId = $_SESSION['user_id'];

$user =
$userModel->getUserById(
    $connection,
    $userId
);

$userData =
$user->fetch_assoc();

$room_type_id =
$_GET['room_type_id'];

$checkin =
$_GET['checkin'];

$checkout =
$_GET['checkout'];

$guests =
$_GET['guests'];

$roomType =
$roomModel->getRoomTypeById(
    $connection,
    $room_type_id
);

$roomData =
$roomType->fetch_assoc();

$days =

(
    strtotime($checkout)
    -
    strtotime($checkin)
)

/

(60 * 60 * 24);

$totalPrice =
$days
*
$roomData['price_per_night'];

?>

<!DOCTYPE html>

<html>

<head>

<title>

Booking Form

</title>

<link
rel="stylesheet"
href="../CSS/task3.css">

</head>

<body>

<div class="content">

<div id="bookingArea">

<h2 class="page-title">

Booking Confirmation

</h2>



<div class="form-container">

<p>

<strong>

Room Type:

</strong>

<?php echo $roomData['name']; ?>

</p>



<p>

<strong>

Description:

</strong>

<?php echo $roomData['description']; ?>

</p>



<p>

<strong>

Price Per Night:

</strong>

BDT
<?php echo $roomData['price_per_night']; ?>

</p>



<p>

<strong>

Check-in:

</strong>

<?php echo $checkin; ?>

</p>



<p>

<strong>

Check-out:

</strong>

<?php echo $checkout; ?>

</p>



<p>

<strong>

Guests:

</strong>

<?php echo $guests; ?>

</p>



<p>

<strong>

Total Price:

</strong>

BDT
<?php echo $totalPrice; ?>

</p>

</div>



<form id="bookingForm"
class="form-container">

<input
type="hidden"
id="room_type_id"
value="<?php echo $room_type_id; ?>">



<input
type="hidden"
id="checkin"
value="<?php echo $checkin; ?>">



<input
type="hidden"
id="checkout"
value="<?php echo $checkout; ?>">



<input
type="hidden"
id="guests"
value="<?php echo $guests; ?>">



<p>

Name

</p>

<input
type="text"
class="form-input"
name="name"
value="<?php echo $userData['name']; ?>">



<p>

Phone

</p>

<input
type="text"
class="form-input"
name="phone"
value="<?php echo $userData['phone']; ?>">



<br><br>



<input
type="button"
value="Confirm Booking"
id="confirmButton"
class="simple-btn"
onclick="confirmRoomBooking()">

</form>

</div>

<script src="../JS/booking.js"></script>

</div>

</body>

</html>