<?php

session_start();

include "../Model/UserModel.php";
include "../Config/DatabaseCon.php";

$db = new DatabaseCon();
$connection = $db->openCon();

$userModel = new UserModel();

$action = $_POST['action'] ?? "";



if($action == "register")
{

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $phone = trim($_POST['phone']);
    $nationality = trim($_POST['nationality']);



    $hasError = false;



    if(empty($name))
    {
        $_SESSION['nameError'] = "Name is required";
        $hasError = true;
    }



    if(empty($email))
    {
        $_SESSION['emailError'] = "Email is required";
        $hasError = true;
    }

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $_SESSION['emailError'] = "Invalid email format";
        $hasError = true;
    }



    if(empty($password))
    {
        $_SESSION['passwordError'] = "Password is required";
        $hasError = true;
    }

    else if(strlen($password) < 6)
    {
        $_SESSION['passwordError'] =
        "Password must be at least 6 characters";

        $hasError = true;
    }



    if(empty($phone))
    {
        $_SESSION['phoneError'] = "Phone is required";
        $hasError = true;
    }



    if(empty($nationality))
    {
        $_SESSION['nationalityError'] =
        "Nationality is required";

        $hasError = true;
    }



    $existingUser =
    $userModel->getUserByEmail(
        $connection,
        $email
    );



    if($existingUser->num_rows > 0)
    {
        $_SESSION['emailError'] =
        "Email already exists";

        $hasError = true;
    }



    if($hasError)
    {
        header("Location: ../Views/register.php");
        exit();
    }



    $hashedPassword =
    password_hash(
        $password,
        PASSWORD_DEFAULT
    );



    $role = "guest";

    $preferred_room_type_id = NULL;

    $special_requests = "";



    $result =
    $userModel->registerUser(

        $connection,

        $name,

        $email,

        $hashedPassword,

        $phone,

        $nationality,

        $role,

        $preferred_room_type_id,

        $special_requests

    );



    if($result)
    {

        header("Location: ../Views/login.php");

    }

    else
    {

        echo "Registration Failed";

    }

}

else if($action == "login")
{

    $email = trim($_POST['email']);

    $password = trim($_POST['password']);



    $hasError = false;



    if(empty($email))
    {
        $_SESSION['emailError'] = "Email is required";

        $hasError = true;
    }



    if(empty($password))
    {
        $_SESSION['passwordError'] = "Password is required";

        $hasError = true;
    }



    if($hasError)
    {
        header("Location: ../Views/login.php");

        exit();
    }




    $user =
    $userModel->getUserByEmail(
        $connection,
        $email
    );




    if($user->num_rows > 0)
    {

        $userData =
        $user->fetch_assoc();




        if(

            password_verify(

                $password,

                $userData['password_hash']

            )

        )
        {

            $_SESSION['user_id'] =
            $userData['id'];



            $_SESSION['name'] =
            $userData['name'];



            $_SESSION['role'] =
            $userData['role'];




            if($userData['role'] == "admin")
            {

                header("Location: ../Views/adminDashboard.php");

            }

            else
            {

                header("Location: ../Views/userDashboard.php");

            }

        }

        else
        {

            $_SESSION['passwordError'] =
            "Incorrect Password";



            header("Location: ../Views/login.php");

        }

    }

    else
    {

        $_SESSION['emailError'] =
        "Email not found";



        header("Location: ../Views/login.php");

    }

}

?>