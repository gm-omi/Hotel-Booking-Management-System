<?php

include "../Includes/auth.php";

include "../Includes/navbar.php";

include "../Includes/sidebar.php";

include "../Config/DatabaseCon.php";

include "../Model/BookingModel.php";

$db = new DatabaseCon();

$connection = $db->openCon();

$bookingModel =
new BookingModel();

$userId =
$_SESSION['user_id'];

$result =
$bookingModel->getBookingsByUser(

    $connection,

    $userId

);

?>

<!DOCTYPE html>

<html>

<head>

<title>

My Bookings

</title>

<link
rel="stylesheet"
href="../CSS/task3.css">

</head>

<body>

<div class="content">

<h2 class="page-title">

My Bookings

</h2>



<table class="simple-table">

<tr>

<th>

Booking ID

</th>

<th>

Room Type

</th>

<th>

Check-in

</th>

<th>

Check-out

</th>

<th>

Total Price

</th>

<th>

Status

</th>

<th>

Action

</th>

</tr>

<?php

while(
    $row =
    $result->fetch_assoc()
)

{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>



<td>

<?php echo $row['room_type_name']; ?>

</td>



<td>

<?php echo $row['checkin_date']; ?>

</td>



<td>

<?php echo $row['checkout_date']; ?>

</td>



<td>

BDT
<?php echo $row['total_price']; ?>

</td>



<td>

<?php

$statusClass = "";

if($row['status'] == "Pending")
{
    $statusClass = "status-pending";
}

else if($row['status'] == "Confirmed")
{
    $statusClass = "status-confirmed";
}

else if($row['status'] == "Cancelled")
{
    $statusClass = "status-cancelled";
}

else
{
    $statusClass = "status-checked";
}

?>

<span class="<?php echo $statusClass; ?>">

<?php echo $row['status']; ?>

</span>

</td>



<td>

<?php

if(

    (
        $row['status'] == "Pending"
        ||
        $row['status'] == "Confirmed"
    )

    &&

    strtotime($row['checkin_date'])

    >

    strtotime(date("Y-m-d"))

)

{

?>

<button
class="simple-btn"
onclick="cancelBooking(
<?php echo $row['id']; ?>
)">

Cancel Booking

</button>

<?php

}

?>

</td>

</tr>

<?php

}

?>

</table>

<script src="../JS/booking.js"></script>

</div>

</body>

</html>