<?php

session_start();

include __DIR__ . "/../config/DatabaseCon.php";
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

$model = new roomTypeModel();

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


if($action == 'list')
{
    $roomTypesResult = $model->getAllRoomTypes($connection);
    
    $roomTypes = [];

    while($row = $roomTypesResult->fetch_assoc())
    {
        $roomTypes[] = $row;
    }

    $db->closeCon($connection);

    include __DIR__ . "/../Views/roomsTypes/roomTypesList.php";

    exit();
}


if($action == 'create')
{
    $errors = [];
    $old = [];

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        if(empty($_POST['name']))
        {
            $errors['name'] = "Name is required";
        }

        
        if(empty($_POST['description']))
        {
            $errors['description'] = "Description is required";
        }

        
        if(empty($_POST['price_per_night']))
        {
            $errors['price_per_night'] = "Price is required";
        }
        else if($_POST['price_per_night'] <= 0)
        {
            $errors['price_per_night'] = "Price must be greater than 0";
        }

        
        if(empty($_POST['max_capacity']))
        {
            $errors['max_capacity'] = "Capacity is required";
        }
        else if($_POST['max_capacity'] < 1)
        {
            $errors['max_capacity'] = "Capacity must be at least 1 person";
        }
        else if($_POST['max_capacity'] > 8)
        {
            $errors['max_capacity'] = "Capacity cannot be more than 8 persons";
        }

        
        $thumbnailPath = "";

        if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0)
        {
            $tmp = $_FILES['thumbnail']['tmp_name'];
            $size = $_FILES['thumbnail']['size'];
            $type = mime_content_type($tmp);

            if(!in_array($type, ['image/jpeg', 'image/png']))
            {
                $errors['thumbnail'] = "Only JPG/PNG images allowed";
            }
            else if($size > 2 * 1024 * 1024)
            {
                $errors['thumbnail'] = "Image size must be less than 2MB";
            }
            else
            {
               $dir = __DIR__ . '/../public/uploads/';

                if(!is_dir($dir))
                {
                    mkdir($dir);
                }

                $filename =
                    basename(
                        $_FILES['thumbnail']['name']
                    );

                if(move_uploaded_file($tmp, $dir . $filename))
                {
                    $thumbnailPath = 'public/uploads/rooms/' . $filename;
                }
                else
                {
                    $errors['thumbnail'] = "Failed to upload image";
                }
            }
        }
        else
        {
            $errors['thumbnail'] = "Thumbnail image is required";
        }

        
        if(empty($errors))
        {
            $amenities_array = $_POST['amenities'] ?? [];
            $amenities_json = json_encode($amenities_array);

            $result = $model->insertRoomType(
                $connection,
                $_POST['name'],
                $_POST['description'],
                $_POST['price_per_night'],
                $_POST['max_capacity'],
                $thumbnailPath,
                $amenities_json
            );

            if($result)
            {
                $_SESSION['message'] = "Room Type created successfully!";
                $db->closeCon($connection);
                header("Location: roomTypeController.php?action=list");
                exit();
            }
            else
            {
                $errors['general'] = "Failed to create room type";
            }
        }

        
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        
        $db->closeCon($connection);
        header("Location: roomTypeController.php?action=create");
        exit();
    }

    
    $errors = $_SESSION['errors'] ?? [];
    $old = $_SESSION['old'] ?? [];
    
    
    unset($_SESSION['errors']);
    unset($_SESSION['old']);

    $db->closeCon($connection);

    include __DIR__ . "/../Views/roomsTypes/roomTypesForm.php";

    exit();
}


if($action == 'edit')
{
    $data = $model->getRoomTypeById($connection, $id);

    if(!$data)
    {
        $_SESSION['message'] = "Room type not found!";
        $db->closeCon($connection);
        header("Location: roomTypeController.php?action=list");
        exit();
    }

    
    if(!empty($data['amenities']))
    {
        $data['amenities_array'] = json_decode($data['amenities'], true);
    }

    $errors = [];
    $old = $data;

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        if(empty($_POST['name']))
        {
            $errors['name'] = "Name is required";
        }

       
        if(empty($_POST['description']))
        {
            $errors['description'] = "Description is required";
        }

        
        if(empty($_POST['price_per_night']))
        {
            $errors['price_per_night'] = "Price is required";
        }
        else if($_POST['price_per_night'] <= 0)
        {
            $errors['price_per_night'] = "Price must be greater than 0";
        }

        
        if(empty($_POST['max_capacity']))
        {
            $errors['max_capacity'] = "Capacity is required";
        }
        else if($_POST['max_capacity'] < 1)
        {
            $errors['max_capacity'] = "Capacity must be at least 1 person";
        }
        else if($_POST['max_capacity'] > 8)
        {
            $errors['max_capacity'] = "Capacity cannot be more than 8 persons";
        }

      
        $thumbnailPath = $data['thumbnail_path'];

        if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0)
        {
            $tmp = $_FILES['thumbnail']['tmp_name'];
            $size = $_FILES['thumbnail']['size'];
            $type = mime_content_type($tmp);

            if(!in_array($type, ['image/jpeg', 'image/png']))
            {
                $errors['thumbnail'] = "Only JPG/PNG images allowed";
            }
            else if($size > 2 * 1024 * 1024)
            {
                $errors['thumbnail'] = "Image size must be less than 2MB";
            }
            else
            {
                $dir = $dir = __DIR__ . '/../public/uploads/';

                if(!is_dir($dir))
                {
                    mkdir($dir);
                }

                $filename =
                        basename(
                            $_FILES['thumbnail']['name']
                        );

                if(move_uploaded_file($tmp, $dir . $filename))
                {
                    if(!empty($data['thumbnail_path']) && 
                       file_exists(
                                    __DIR__ .
                                    '/../public/' .
                                    $data['thumbnail_path']
                                ))
                    {
                        unlink(
                                __DIR__ .
                                '/../public/' .
                                $data['thumbnail_path']
                            );
                    }

                    $thumbnailPath =
                            'uploads/' . $filename;
                }
                else
                {
                    $errors['thumbnail'] = "Failed to upload image";
                }
            }
        }

       
        if(empty($errors))
        {
            $amenities_array = $_POST['amenities'] ?? [];
            $amenities_json = json_encode($amenities_array);

            $result = $model->updateRoomType(
                $connection,
                $id,
                $_POST['name'],
                $_POST['description'],
                $_POST['price_per_night'],
                $_POST['max_capacity'],
                $thumbnailPath,
                $amenities_json
            );

            if($result)
            {
                $_SESSION['message'] = "Room Type updated successfully!";
                $db->closeCon($connection);
                header("Location: roomTypeController.php?action=list");
                exit();
            }
            else
            {
                $errors['general'] = "Failed to update room type";
            }
        }

       
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        
        $db->closeCon($connection);
        header("Location: roomTypeController.php?action=edit&id=" . $id);
        exit();
    }

    
    $errors = $_SESSION['errors'] ?? [];
    $old = array_merge($data, $_SESSION['old'] ?? []);
    
    
    unset($_SESSION['errors']);
    unset($_SESSION['old']);

    $db->closeCon($connection);

    include __DIR__ . "/../Views/roomsTypes/roomTypesForm.php";

    exit();
}

$db->closeCon($connection);

header("Location: roomTypeController.php?action=list");

exit();

?>