<?php

include "../config/DatabaseCon.php";

include "../Model/RoomModel.php";



$checkin = $_GET['checkin'];

$checkout = $_GET['checkout'];

$guests = $_GET['guests'];

$today =
date("Y-m-d");



if(
    empty($checkin)
    ||
    empty($checkout)
    ||
    empty($guests)
)
{

    echo "

            <p style='color:red;'>

            All fields are required

            </p>

            ";


    exit();

}




if($checkin < $today)
{

    echo
    "
            <p style='color:red;'>
            Check-in date cannot be in the past
            </p>
            ";

    exit();

}




if($checkout <= $checkin)
{

    echo
    "
            <p style='color:red;'>
            Check-out must be after check-in
            </p>
            ";

    exit();

}




if($guests <= 0)
{

    echo
    "
            <p style='color:red;'>
            Guest number must be at least 1
            </p>
            ";

    exit();

}

$db = new DatabaseCon();

$connection = $db->openCon();



$room = new RoomModel();



$result = $room->getAvailableRoomTypes(

    $connection,

    $checkin,

    $checkout,

    $guests

);



while($row = $result->fetch_assoc())
{

    include "../Views/roomCard.php";

}



$db->closeCon($connection);

?>