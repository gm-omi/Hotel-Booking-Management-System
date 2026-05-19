<?php

include "../Includes/adminAuth.php";
include "../Includes/navbar.php";

include "../Includes/sidebar.php";

include "../Config/DatabaseCon.php";

include "../Model/BookingModel.php";

include "../Model/RoomModel.php";



$db = new DatabaseCon();

$connection = $db->openCon();



$booking =
new BookingModel();

$room =
new RoomModel();




$arrivals =
$booking->getTodayArrivals(
    $connection
);



$departures =
$booking->getTodayDepartures(
    $connection
);




$totalRooms =
$room->getTotalRooms(
    $connection
);



$occupiedRooms =
$room->getOccupiedRooms(
    $connection
);



$availableRooms =
$room->getAvailableRoomCount(
    $connection
);



$maintenanceRooms =
$room->getMaintenanceRooms(
    $connection
);

$revenueData =
$booking->getWeeklyRevenue(
    $connection
);




$weeks = [];

$revenues = [];



while(
    $row =
    $revenueData->fetch_assoc()
)
{

    $weeks[] =
    "Week " . $row['week'];



    $revenues[] =
    $row['revenue'];

}

?>
 <div class="content">

<h2>

Admin Dashboard

</h2>



<h3>

Room Summary

</h3>



<p>

Total Rooms:
<?php echo $totalRooms['total']; ?>

</p>



<p>

Occupied Rooms:
<?php echo $occupiedRooms['occupied']; ?>

</p>



<p>

Available Rooms:
<?php echo $availableRooms['available']; ?>

</p>



<p>

Maintenance Rooms:
<?php echo $maintenanceRooms['maintenance']; ?>

</p>

<h3>

Today's Arrivals

</h3>



<table border="1" cellpadding="10">

<tr>

<th>

Booking ID

</th>

<th>

Guest Name

</th>

<th>

Check-in

</th>

<th>

Check-out

</th>

<th>

Status

</th>

</tr>



<?php

while(
    $row =
    $arrivals->fetch_assoc()
)

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

<?php echo $row['checkin_date']; ?>

</td>



<td>

<?php echo $row['checkout_date']; ?>

</td>



<td>

<?php echo $row['status']; ?>

</td>

</tr>

<?php

}

?>

</table>

<h3>

Today's Departures

</h3>



<table border="1" cellpadding="10">

<tr>

<th>

Booking ID

</th>

<th>

Guest Name

</th>

<th>

Check-out

</th>

<th>

Status

</th>

</tr>



<?php

while(
    $row =
    $departures->fetch_assoc()
)

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

<?php echo $row['checkout_date']; ?>

</td>



<td>

<?php echo $row['status']; ?>

</td>

</tr>

<?php

}

?>

</table>

<h3>

Weekly Revenue

</h3>



<div style="width:700px;">

<canvas
id="revenueChart">
</canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

let weeks =

<?php echo json_encode($weeks); ?>;



let revenues =

<?php echo json_encode($revenues); ?>;




let ctx =

document.getElementById(
    "revenueChart"
);




new Chart(ctx,
{

    type: "bar",



    data:
    {

        labels: weeks,



        datasets:
        [

            {

                label:
                "Revenue",



                data: revenues,



                borderWidth: 1

            }

        ]

    }

});

</script>

</div>