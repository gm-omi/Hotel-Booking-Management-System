<?php

session_start();

include __DIR__ . "/../config/DatabaseCon.php";
include __DIR__ . "/../Model/roomModel.php";
include __DIR__ . "/../Model/roomTypeModel.php";

if(
    empty($_SESSION['user_id']) ||
    $_SESSION['role'] != "admin"
)
{
    header("Location: ../Views/login.php");
    exit();
}

$db = new DatabaseCon();
$connection = $db->openCon();

$roomModel = new roomModel();
$roomTypeModel = new RoomTypeModel();

$action = $_POST["action"] ?? $_GET["action"] ?? "";


if(
    $action == "list" ||
    $action == ""
)
{
    $roomTypes = $roomTypeModel->getAllRoomTypesResult($connection);

    include __DIR__ . "/../Views/Rooms/roomsList.php";

    exit();
}


header("Content-Type: application/json");


if($action == "load")
{
    $result = $roomModel->getAllRoomsWithOccupancy($connection);

    $rooms = [];

    while($row = $result->fetch_assoc())
    {
        $rooms[] = $row;
    }

    echo json_encode(["success" => true, "data" => $rooms]);

    exit();
}


if($action == "toggle_status")
{
    $success = $roomModel->toggleStatus($connection, $_POST["id"]);

    echo json_encode(["success" => $success]);

    exit();
}


if($action == "getRoomTypes")
{
    $result = $roomTypeModel->getAllRoomTypesResult($connection);

    $types = [];

    while($row = $result->fetch_assoc())
    {
        $types[] = $row;
    }

    echo json_encode(["success" => true, "data" => $types]);

    exit();
}


if($action == "getRoom")
{
    $result = $roomModel->getRoomById($connection, $_POST["id"]);

    echo json_encode(["success" => true, "data" => $result->fetch_assoc()]);

    exit();
}


if($action == "add")
{
    $room_number = $_POST["room_number"];
    $floor = $_POST["floor"];
    $room_type_id = $_POST["room_type_id"];
    $status = $_POST["status"];

    if(empty($room_number))
    {
        echo json_encode(["success" => false, "message" => "Room Number is required!"]);
        exit();
    }

    if($room_number < 0)
    {
        echo json_encode(["success" => false, "message" => "Room Number cannot be negative!"]);
        exit();
    }

    if(empty($floor) && $floor !== 0)
    {
        echo json_encode(["success" => false, "message" => "Floor is required!"]);
        exit();
    }

    if($floor < 0)
    {
        echo json_encode(["success" => false, "message" => "Floor cannot be negative!"]);
        exit();
    }

    if(empty($room_type_id))
    {
        echo json_encode(["success" => false, "message" => "Room Type is required!"]);
        exit();
    }

    $checkSql = "SELECT COUNT(*) AS count FROM rooms WHERE room_number = ?";
    $checkStmt = $connection->prepare($checkSql);
    $checkStmt->bind_param("s", $room_number);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $row = $checkResult->fetch_assoc();

    if($row['count'] > 0)
    {
        echo json_encode(["success" => false, "message" => "Room number already exists!"]);
        exit();
    }

    $res = $roomModel->insertRoom($connection, $room_type_id, $room_number, $floor, $status);

    if($res == "SUCCESS" || $res === true)
    {
        echo json_encode(["success" => true, "message" => "Room added successfully!"]);
    }
    else
    {
        echo json_encode(["success" => false, "message" => "Failed to add room!"]);
    }

    exit();
}


if($action == "update")
{
    $room_id = $_POST["id"];
    $room_number = $_POST["room_number"];
    $floor = $_POST["floor"];
    $room_type_id = $_POST["room_type_id"];
    $status = $_POST["status"];

    if(empty($room_number))
    {
        echo json_encode(["success" => false, "message" => "Room Number is required!"]);
        exit();
    }

    if($room_number < 0)
    {
        echo json_encode(["success" => false, "message" => "Room Number cannot be negative!"]);
        exit();
    }

    if(empty($floor) && $floor !== 0)
    {
        echo json_encode(["success" => false, "message" => "Floor is required!"]);
        exit();
    }

    if($floor < 0)
    {
        echo json_encode(["success" => false, "message" => "Floor cannot be negative!"]);
        exit();
    }

    $currentSql = "SELECT room_number FROM rooms WHERE id = ?";
    $currentStmt = $connection->prepare($currentSql);
    $currentStmt->bind_param("i", $room_id);
    $currentStmt->execute();
    $currentResult = $currentStmt->get_result();
    $currentRoom = $currentResult->fetch_assoc();

    if($currentRoom['room_number'] != $room_number)
    {
        $checkSql = "SELECT COUNT(*) AS count FROM rooms WHERE room_number = ? AND id != ?";
        $checkStmt = $connection->prepare($checkSql);
        $checkStmt->bind_param("si", $room_number, $room_id);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();
        $row = $checkResult->fetch_assoc();

        if($row['count'] > 0)
        {
            echo json_encode(["success" => false, "message" => "Room number already exists!"]);
            exit();
        }
    }

    $res = $roomModel->updateRoom($connection, $room_id, $room_number, $floor, $room_type_id, $status);

    if($res == "SUCCESS" || $res === true)
    {
        echo json_encode(["success" => true, "message" => "Room updated successfully!"]);
    }
    else
    {
        echo json_encode(["success" => false, "message" => "Failed to update room!"]);
    }

    exit();
}


if($action == "delete")
{
    $room_id = $_POST["id"];
    
    $checkSql = "SELECT COUNT(*) AS count FROM bookings 
                 WHERE room_id = ? 
                 AND status IN ('Pending', 'Confirmed', 'Checked-In')
                 AND checkout_date >= CURDATE()";
    
    $checkStmt = $connection->prepare($checkSql);
    $checkStmt->bind_param("i", $room_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $row = $checkResult->fetch_assoc();
    
    if($row['count'] > 0)
    {
        echo json_encode(["success" => false, "message" => "Cannot delete - Room has active or future bookings!"]);
        exit();
    }
    
    $res = $roomModel->deleteRoom($connection, $room_id);
    
    if($res == "SUCCESS" || $res === true)
    {
        echo json_encode(["success" => true, "message" => "Room deleted successfully!"]);
    }
    else
    {
        echo json_encode(["success" => false, "message" => "Delete failed!"]);
    }
    
    exit();
}

$db->closeCon($connection);

?>