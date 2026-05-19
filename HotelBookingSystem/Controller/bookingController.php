<?php

session_start();

include "../config/DatabaseCon.php";

include "../Model/BookingModel.php";

include "../Model/RoomModel.php";



$action = $_POST['action'] ?? "";

$booking_id = $_POST['booking_id'] ?? "";



$db = new DatabaseCon();

$connection = $db->openCon();



$booking = new BookingModel();

$room = new RoomModel();




if($action == "confirm")
{

    $result = $booking->confirmBooking(
        $connection,
        $booking_id
    );



    if($result)
    {

        echo "Booking Confirmed";

    }

    else
    {

        echo "Confirmation Failed";

    }

}





else if($action == "checkin")
{

    $result = $booking->checkInBooking(
        $connection,
        $booking_id
    );



    if($result)
    {

        $bookingData = $booking
        ->getBookingById(
            $connection,
            $booking_id
        );



        $bookingRow = $bookingData->fetch_assoc();



        $room->updateRoomStatus(
            $connection,
            $bookingRow['room_id'],
            "occupied"
        );



        echo "Checked In Successfully";

    }

    else
    {

        echo "Check In Failed";

    }

}





else if($action == "checkout")
{

    $result = $booking->checkOutBooking(
        $connection,
        $booking_id
    );



    if($result)
    {

        $bookingData = $booking
        ->getBookingById(
            $connection,
            $booking_id
        );



        $bookingRow = $bookingData->fetch_assoc();



        $room->updateRoomStatus(
            $connection,
            $bookingRow['room_id'],
            "available"
        );



        echo "Checked Out Successfully";

    }

    else
    {

        echo "Check Out Failed";

    }

}


else if($action == "book")
{

    $roomTypeId = $_POST['room_type_id'];

    $checkin = $_POST['checkin'];

    $checkout = $_POST['checkout'];

    $guests = $_POST['guests'];



    $userId = $_SESSION['user_id'];



    $roomModel = new RoomModel();




    $availableRoom =
    $roomModel->getAvailableRoomByType(

        $connection,

        $roomTypeId,

        $checkin,

        $checkout

    );




    if($availableRoom->num_rows > 0)
    {

        $room =
        $availableRoom->fetch_assoc();




        $roomId = $room['id'];



        $pricePerNight =
        $room['price_per_night'];



        $days =

        (
            strtotime($checkout)

            -

            strtotime($checkin)

        )

        /

        (60 * 60 * 24);




        $totalPrice =
        $days * $pricePerNight;




        $booking =
        new BookingModel();




        $result =
        $booking->createBooking(

            $connection,

            $userId,

            $roomId,

            $checkin,

            $checkout,

            $totalPrice

        );

        $bookingId =
       $connection->insert_id;




        if($result)
        {

           echo "

                   

            <div class='success-box'>

            <h2>

            Booking Successful

            </h2>

            <p>

            Booking ID:
            $bookingId

            </p>

            <p>

            Status:
            Pending

            </p>

            <p>

            Check-in:
            $checkin

            </p>

            <p>

            Check-out:
            $checkout

            </p>

            <p>

            Total Price:
            BDT $totalPrice

            </p>

            </div>

            ";

        }

        else
        {

            echo "Booking Failed";

        }

    }

    else
    {

        echo "No Room Available";

    }

}

else if($action == "cancel")
{

    $bookingId =
    $_POST['booking_id'];



    $result =
    $booking->cancelBooking(

        $connection,

        $bookingId

    );



    if($result)
    {

        echo
        "Booking Cancelled Successfully";

    }

    else
    {

        echo
        "Cancellation Failed";

    }

}



$db->closeCon($connection);

?>