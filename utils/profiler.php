<?php

require '../services/ImageService.php';
require '../database/connection_db.php';

session_start();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$response = array();
switch ($requestMethod) {
    case 'POST':

        if (isset($_SESSION["id"])) {

            if (isset($_FILES["image"])) {
                $imageAlready = getImagesByPath($_SESSION["id"], "users", "../wwwroot/images/users/"); 
            
                $response = saveImage($_SESSION["id"], "users", $_FILES["image"], "../");
    
                if (isset($imageAlready) && !empty($imageAlready) && $response["status"] == 1) {
                    foreach ($imageAlready as $image => $path) {
                        $response["delete" . $image] = deleteImage("../wwwroot/images/users/" . $path);
                    }
                }
            } else if (isset($_POST["email"]) && isset($_POST["phone"])) {
                $email = $_POST["email"];
                $phone = str_replace(["(", ")", "-", " "], "", $_POST["phone"]);

                $sql = "UPDATE USER SET email = '$email', phone = '$phone' WHERE ID = " . $_SESSION["id"];

                try {
                    $result = mysqli_query($connect, $sql) or die(json_encode("Erro ao atualizar dados"));
                } catch (\Throwable $th) {
                    echo json_encode(mysqli_error($connect));
                    exit();
                }

                $response["success"] = $result;
                $response["message"] = $result ? "Atualizado com sucesso" : "Erro ao atualizar";
                

            }


        }

        echo json_encode($response);

        break;
    
    case 'GET':

        if (isset($_SESSION["id"])) {
            $response['image'] = getImagesByPath($_SESSION["id"], "users", "../wwwroot/images/users/"); 

            $sql = "SELECT email, phone, name, surName FROM USER WHERE ID = ".  $_SESSION["id"];
            
            $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de usuário");
        
            $users = [];
        
            $users = array();
            while( $data = mysqli_fetch_assoc($result) ) {
                $users[] = $data;
            }

            $response['user'] = $users[0];


        }

        echo json_encode($response);

        break;
    case 'DELETE':
        $response = array();
        if (isset($_SESSION["id"])) {
            $response["message"] = deleteImages($_SESSION["id"], "users", "../");
        }
        echo json_encode($response);
}