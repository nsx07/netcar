<?php

require '../services/ImageService.php';

session_start();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$response = array();
switch ($requestMethod) {
    case 'POST':

        if (isset($_SESSION["id"]) && isset($_FILES["image"])) {
            $imageAlready = getImagesByPath($_SESSION["id"], "users", "../wwwroot/images/users/"); 
            if (isset($imageAlready) && !empty($imageAlready)) {
                deleteImages($_SESSION["id"], "users");
            }
            
            $response['message'] = saveImage($_SESSION["id"], "users", $_FILES["image"]);
        }

        echo json_encode($response);

        break;
    
    case 'GET':

        if (isset($_SESSION["id"])) {
            $response['message'] = getImagesByPath($_SESSION["id"], "users", "../wwwroot/images/users/"); 
        }

        echo json_encode($response);

        break;
}