<?php

class RoomModel
{

    function insertRoom(
        $connection,
        $room_type_id,
        $room_number,
        $floor,
        $status
    )
    {

        $sql = "INSERT INTO rooms(
            room_type_id,
            room_number,
            floor,
            status
        )

        VALUES(
            ?,?,?,?
        )";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "isis",
            $room_type_id,
            $room_number,
            $floor,
            $status
        );


        return $statement->execute();

    }



    function getAllRooms($connection)
    {

        $sql = "SELECT

        rooms.id,
        rooms.room_number,
        rooms.floor,
        rooms.status,
        room_types.name AS room_type

        FROM rooms

        JOIN room_types
        ON rooms.room_type_id = room_types.id";


        return $connection->query($sql);

    }

function getAllRoomsWithOccupancy($connection)
{

    $sql = "

    SELECT 

        r.id,

        r.room_number,

        r.floor,

        r.status,

        rt.name AS room_type,

        CASE

            WHEN LOWER(r.status) = 'maintenance'

            THEN 'Maintenance'

            WHEN EXISTS (

                SELECT 1

                FROM bookings b 

                WHERE b.room_id = r.id 

                AND b.status IN
                ('Pending','Confirmed','Checked-In')

            )

            THEN 'Occupied'

            ELSE 'Available'

        END AS occupancy_status

    FROM rooms r

    JOIN room_types rt

    ON r.room_type_id = rt.id

    ORDER BY r.room_number

    ";


    return $connection->query($sql);

}

    function updateRoom(
        $connection,
        $id,
        $room_number,
        $floor,
        $room_type_id,
        $status
    )
    {

        $sql = "UPDATE rooms
        SET room_number = ?,
            floor = ?,
            room_type_id = ?,
            status = ?
        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "iissi",
            $room_number,
            $floor,
            $room_type_id,
            $status,
            $id
        );


        return $statement->execute();

    }



    function getAvailableRooms($connection)
    {

        $sql = "SELECT * FROM rooms
        WHERE status = 'available'";


        return $connection->query($sql);

    }

    function toggleStatus(
        $connection,
        $id
    )
    {

        $sql = "UPDATE rooms
        SET status = IF(status='available', 'maintenance', 'available')
        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "i",
            $id
        );


        return $statement->execute();

    }



    function getRoomById(
        $connection,
        $id
    )
    {

        $sql = "SELECT * FROM rooms
        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "i",
            $id
        );


        $statement->execute();

        return $statement->get_result();

    }



    function updateRoomStatus(
        $connection,
        $id,
        $status
    )
    {

        $sql = "UPDATE rooms
        SET status = ?
        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "si",
            $status,
            $id
        );


        return $statement->execute();

    }



    function deleteRoom(
        $connection,
        $id
    )
    {

        $sql = "DELETE FROM rooms
        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "i",
            $id
        );


        return $statement->execute();

    }

    function getAvailableRoomTypes(
    $connection,
    $checkin,
    $checkout,
    $guests
)
{

    $sql = "

    SELECT DISTINCT

    room_types.id,

    room_types.name,

    room_types.description,

    room_types.price_per_night,

    room_types.max_capacity,

    room_types.thumbnail_path,

    room_types.amenities

    FROM room_types

    JOIN rooms
    ON room_types.id = rooms.room_type_id

    WHERE

    room_types.max_capacity >= ?

    AND

    rooms.status != 'maintenance'

    AND

    rooms.id NOT IN
    (

        SELECT room_id

        FROM bookings

        WHERE

        status IN
        (
            'Pending',
            'Confirmed',
            'Checked-In'
        )

        AND

        (
            checkin_date < ?
            AND
            checkout_date > ?
        )

    )

    ";



    $statement = $connection->prepare($sql);



    $statement->bind_param(
        "iss",
        $guests,
        $checkout,
        $checkin
    );



    $statement->execute();



    return $statement->get_result();

}

function getAvailableRoomByType(
    $connection,
    $roomTypeId,
    $checkin,
    $checkout
)
{

    $sql = "

    SELECT

    rooms.*,

    room_types.price_per_night

    FROM rooms

    JOIN room_types
    ON rooms.room_type_id = room_types.id

    WHERE

    rooms.room_type_id = ?

    AND

    rooms.status != 'maintenance'

    AND

    rooms.id NOT IN
    (

        SELECT room_id

        FROM bookings

        WHERE

        status IN
        (
            'Pending',
            'Confirmed',
            'Checked-In'
        )

        AND

        (
            checkin_date < ?
            AND
            checkout_date > ?
        )

    )

    LIMIT 1

    ";



    $statement =
    $connection->prepare($sql);




    $statement->bind_param(

        "iss",

        $roomTypeId,

        $checkout,

        $checkin

    );




    $statement->execute();




    return
    $statement->get_result();

}

function getRoomTypeById(
    $connection,
    $room_type_id
)
{

    $sql = "
    
    SELECT *

    FROM room_types

    WHERE id = ?

    ";



    $statement =
    $connection->prepare($sql);



    $statement->bind_param(
        "i",
        $room_type_id
    );



    $statement->execute();



    return
    $statement->get_result();

}

function getTotalRooms(
    $connection
)
{

    $sql = "

    SELECT COUNT(*) AS total

    FROM rooms

    ";



    $result =
    $connection->query($sql);



    return
    $result->fetch_assoc();

}

function getAvailableRoomCount(
    $connection
)
{

    $sql = "

    SELECT COUNT(*) AS available

    FROM rooms

    WHERE status = 'available'

    ";



    $result =
    $connection->query($sql);



    return
    $result->fetch_assoc();

}

function getMaintenanceRooms(
    $connection
)
{

    $sql = "

    SELECT COUNT(*) AS maintenance

    FROM rooms

    WHERE status = 'maintenance'

    ";



    $result =
    $connection->query($sql);



    return
    $result->fetch_assoc();

}

function getOccupiedRooms(
    $connection
)
{

    $sql = "

    SELECT COUNT(*) AS occupied

    FROM bookings

    WHERE status = 'Checked-In'

    ";



    $result =
    $connection->query($sql);



    return
    $result->fetch_assoc();

}

}

?>
