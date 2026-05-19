<?php

class DatabaseCon
{

    function openCon()
    {

        $db_host = "localhost";

        $db_user = "root";

        $db_pass = "";

        $db_name = "hotel_booking_db";



        $connection = new mysqli(
            $db_host,
            $db_user,
            $db_pass,
            $db_name
        );



        if($connection->connect_error)
        {

            die(
                "Connection failed: "
                . $connection->connect_error
            );

        }



        return $connection;

    }



    function closeCon($connection)
    {

        $connection->close();

    }

}



?>