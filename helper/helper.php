<?php
function post($key)
{
    return $_POST[$key] ?? null;
}


$errors = [];
function ValidationLogin($keys)
{
    $errors = [];
    foreach ($keys as $key) {
        if (!isset($_POST[$key]) || empty($_POST[$key])) {
            $errors[$key] = "$key field is required";
        }
    }
    return $errors;
}



function getUserDetails($connection)
{
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION["user_id"];
        $query = "SELECT * FROM users WHERE id= ?";
        $dataquery = $connection->prepare($query);
        $dataquery->execute([$user_id]);
        return $user_data = $dataquery->fetch(PDO::FETCH_ASSOC);

    } else {
        return null;
    }
}



function UserLoginAuth()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}


function view($view)
{
    header("Location: $view");
    exit();
}
function route($path)
{
    return 'http://localhost/Blog-Website/' . $path;
}



function file_upload($uploadDir, $file) {
    $allowedExtensions = ['jpg', 'jpeg', 'png',"webp"];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExtension, $allowedExtensions)) {
        return false; 
    }

    $tmpName = $file['tmp_name'];
    $uniqueName = uniqid() . '.' . $fileExtension; 
    $uploadDir = rtrim($uploadDir, '/'); 
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return false; 
        }
    }
    $uploadFile = $uploadDir . '/' . $uniqueName;
    if (move_uploaded_file($tmpName, $uploadFile)) {
        return $uniqueName;
    } else {
        return false; 
    }
}