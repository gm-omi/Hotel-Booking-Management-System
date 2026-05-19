<?php

include "../Includes/auth.php";

include "../Includes/navbar.php";

include "../Includes/sidebar.php";

?>

<!DOCTYPE html>

<html>

<head>

<title>

Search Rooms

</title>

<link
rel="stylesheet"
href="../CSS/task3.css">

<script src="../JS/searchRooms.js"></script>

<script src="../JS/booking.js"></script>

</head>

<body>

<div class="content">

<h2 class="page-title">

Search Available Rooms

</h2>



<form class="form-container">

<input
type="date"
id="checkin"
class="form-input"
min="<?php echo date('Y-m-d'); ?>">



<input
type="date"
id="checkout"
class="form-input">



<input
type="number"
id="guests"
class="form-input"
placeholder="Guests"
min="1">



<button
type="button"
class="simple-btn"
onclick="searchRooms()">

Search

</button>

</form>



<div
id="searchError"
class="error-text">

</div>



<div id="roomResults">

</div>

</div>

</body>

</html>