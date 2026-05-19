<?php

class RoomTypeModel
{

    function insertRoomType(
        $connection,
        $name,
        $description,
        $price_per_night,
        $max_capacity,
        $thumbnail_path,
        $amenities
    )
    {

        $sql = "INSERT INTO room_types(
            name,
            description,
            price_per_night,
            max_capacity,
            thumbnail_path,
            amenities
        )

        VALUES(
            ?,?,?,?,?,?
        )";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "ssdiss",
            $name,
            $description,
            $price_per_night,
            $max_capacity,
            $thumbnail_path,
            $amenities
        );


        return $statement->execute();

    }



    function getAllRoomTypes($connection)
    {

        $sql = "SELECT * FROM room_types";

        return $connection->query($sql);

    }



    function updateRoomType(
        $connection,
        $id,
        $name,
        $description,
        $price_per_night,
        $max_capacity
    )
    {

        $sql = "UPDATE room_types
        SET
        name = ?,
        description = ?,
        price_per_night = ?,
        max_capacity = ?

        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "ssdii",
            $name,
            $description,
            $price_per_night,
            $max_capacity,
            $id
        );


        return $statement->execute();

    }



    function deleteRoomType(
        $connection,
        $id
    )
    {

        $sql = "DELETE FROM room_types
        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "i",
            $id
        );


        return $statement->execute();

    }

}



?>