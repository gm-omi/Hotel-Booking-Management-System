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



if(
    $_SESSION['role'] != 'admin'
)
{

    header(
        "Location: ../Views/profile.php"
    );

    exit();

}

?>