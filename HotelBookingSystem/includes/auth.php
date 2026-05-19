<?php

session_start();

if(
    !isset($_SESSION['isLoggedIn'])
)
{

    header(
        "Location: ../Views/login.php"
    );

    exit();

}

?>