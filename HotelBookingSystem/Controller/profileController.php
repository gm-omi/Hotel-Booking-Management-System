<?php

session_start();

include "../Config/DatabaseCon.php";

include "../Model/UserModel.php";



$db =
new DatabaseCon();

$connection =
$db->openCon();



$userModel =
new UserModel();



$id =
$_POST['id'];



$name =
trim(
    $_POST['name']
);



$email =
trim(
    $_POST['email']
);



$phone =
trim(
    $_POST['phone']
);



$password =
trim(
    $_POST['password']
);




$errors = [];




if(empty($name))
{
    $errors[] =
    "Name is required";
}



if(empty($email))
{
    $errors[] =
    "Email is required";
}



if(empty($phone))
{
    $errors[] =
    "Phone is required";
}




if(!empty($errors))
{

    $_SESSION['profile_errors'] =
    $errors;



    header(
        "Location: ../Views/updateProfile.php"
    );



    exit();

}




$result =
$userModel->updateUser(

    $connection,

    $id,

    $name,

    $email,

    $phone,

    $password

);




$db->closeCon(
    $connection
);




if($result)
{

    $_SESSION['profile_success'] =
    "Profile updated successfully";

}

else
{

    $_SESSION['profile_errors'] =
    ["Failed to update profile"];

}




header(
    "Location: ../Views/profile.php"
);

exit();

?>