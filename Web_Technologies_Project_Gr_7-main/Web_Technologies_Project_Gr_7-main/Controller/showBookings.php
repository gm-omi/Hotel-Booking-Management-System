<?php

include "../config/DatabaseCon.php";

include "../Model/BookingModel.php";



$db = new DatabaseCon();

$connection = $db->openCon();



$booking = new BookingModel();

$result = $booking->getAllBookings($connection);

?>



<table border="1" cellpadding="10">

    <tr>

        <th>Booking ID</th>

        <th>Guest Name</th>

        <th>Room Number</th>

        <th>Room Type</th>

        <th>Check In</th>

        <th>Check Out</th>

        <th>Total Price</th>

        <th>Status</th>

        <th>Actual Check In</th>

        <th>Action</th>

    </tr>



<?php

while($row = $result->fetch_assoc())
{

?>

    <tr>

        <td>
            <?php echo $row['id']; ?>
        </td>

        <td>
            <?php echo $row['name']; ?>
        </td>

        <td>
            <?php echo $row['room_number']; ?>
        </td>

        <td>
            <?php echo $row['room_type']; ?>
        </td>

        <td>
            <?php echo $row['checkin_date']; ?>
        </td>

        <td>
            <?php echo $row['checkout_date']; ?>
        </td>

        <td>
            <?php echo $row['total_price']; ?>
        </td>

        <td>
            <?php echo $row['status']; ?>
        </td>

        <td>
            <?php echo $row['actual_checkin']; ?>
        </td>

        <td>

<?php

if($row['status'] == "Pending")
{

?>

<button
onclick="confirmBooking(
<?php echo $row['id']; ?>
)">
    Confirm
</button>

<?php

}

else if($row['status'] == "Confirmed")
{

?>

<button
onclick="checkInBooking(
<?php echo $row['id']; ?>
)">
    Check In
</button>

<?php

}

else if($row['status'] == "Checked-In")
{

?>

<button
onclick="checkOutBooking(
<?php echo $row['id']; ?>
)">
    Check Out
</button>

<?php

}

else
{

    echo "No Action";

}

?>

        </td>

    </tr>

<?php

}

?>

</table>



<?php

$db->closeCon($connection);

?>