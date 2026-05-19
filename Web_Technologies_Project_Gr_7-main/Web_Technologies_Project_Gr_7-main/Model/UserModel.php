<?php

class UserModel
{

    function registerUser(
        $connection,
        $name,
        $email,
        $password,
        $phone,
        $nationality,
        $role,
        $preferred_room_type_id,
        $special_requests
    )
    {

        $sql = "INSERT INTO users(
            name,
            email,
            password_hash,
            phone,
            nationality,
            role,
            preferred_room_type_id,
            special_requests
        )

        VALUES(
            ?,?,?,?,?,?,?,?
        )";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "ssssssis",
            $name,
            $email,
            $password,
            $phone,
            $nationality,
            $role,
            $preferred_room_type_id,
            $special_requests
        );


        return $statement->execute();

    }



    function loginUser(
        $connection,
        $email,
        $password
    )
    {

        $sql = "SELECT * FROM users
        WHERE email = ?
        AND password_hash = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "ss",
            $email,
            $password
        );


        $statement->execute();

        return $statement->get_result();

    }



    function getUserById(
        $connection,
        $id
    )
    {

        $sql = "SELECT * FROM users
        WHERE id = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "i",
            $id
        );


        $statement->execute();

        return $statement->get_result();

    }



    function getUserByEmail(
        $connection,
        $email
    )
    {

        $sql = "SELECT * FROM users
        WHERE email = ?";


        $statement = $connection->prepare($sql);

        $statement->bind_param(
            "s",
            $email
        );


        $statement->execute();

        return $statement->get_result();

    }

}





?>