<?php 
    require '../../database/connection_db.php';
    session_start();

    function setFields($post) {
        $update = "";
        foreach ($post as $field => $value) {
            # code...

            if ($field == "confirmPass" || $field == "id") continue;

            if ($field == "cpf") $value = str_replace([".", "-"], "", $value);

            if ($field == "phone") $value = str_replace(["(", ")", "-", " "], "", $value);
            

            $update = $update . " `$field` = '$value'," ;

        }
        
        $update = substr($update, 0, -1);
           
        return $update;
    }

    $method = $_SERVER["REQUEST_METHOD"];

    switch ($method) {
        case 'POST':
            try {    

        
                if (isset($_POST["id"]) && strlen($_POST["id"]) > 1) {
                    $id = $_POST["id"];
                    $insert = setFields($_POST);
                    $sql = "UPDATE USER SET $insert WHERE ID = $id ";                     

                } else {

                    $name = $_POST["name"];
                    $birthDate = $_POST["birthDate"];
                    $cpf = $_POST["cpf"];
                    $email = $_POST["email"];
                    $phone = $_POST["phone"];
                    $password = $_POST["password"];
                    $surname = $_POST["surname"];
                    $id_access = $_POST["id_access"] ?? 2;
                    $password = base64_encode($password);
                    $cpf = str_replace([".", "-"], "", $cpf);
                    $phone = str_replace(["(", ")", "-", " "], "", $phone);
                    $response["method"] = "new";
    
                    $sql = "INSERT INTO user 
                    (id_access, name, surname, birthDate, email, cpf, phone, password) VALUES 
                    ($id_access,'$name', '$surname', '$birthDate', '$email', '$cpf', '$phone', '$password')"; 
                }
        
                $row = mysqli_query($connect ,$sql);
                $response["success"] = true;
        
                echo json_encode($response);
            } catch (\Throwable $th) {
                echo json_encode(mysqli_error($connect));
            }
            break;
        case 'DELETE':
            $url = $_SERVER['REQUEST_URI'];
            $url = preg_match('!\d+!', $url, $id);
            $id = $id[0];

            $sql = "DELETE FROM USER WHERE ID = '$id'";

            $result = mysqli_query($connect, $sql) or die ("Erro ao deletar usuário");

            $response["success"] = $result;

            echo json_encode($response);
            break;
        case 'GET':
            # code...
            if (isset($_GET["keyword"]) && $_GET["keyword"] != NULL) {
                $key = $_GET["keyword"];
                $sql = "SELECT * FROM USER 
                        WHERE ID = '$key' or NAME LIKE '%$key%' OR SURNAME LIKE '%$key%' OR EMAIL LIKE '%$key%' OR CPF LIKE '%$key%' OR PHONE LIKE '%$key%'  ";
            } else {
                $sql = "SELECT * FROM USER";
            }
            
            $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de usuário");
        
            $users = [];
        
            $users = array();
            while( $data = mysqli_fetch_assoc($result) ) {
                $users[] = $data;
            }
        
            echo json_encode($users);
            break;
        
    }



