<?php 
    require '../../database/connection_db.php';
    session_start();

    function setFields($post) {
        $update = "";
        foreach ($post as $field => $value) {
            # code...     

            $update = $update . " `$field` = '$value'," ;

        }
        
        $update = substr($update, 0, -1);
           
        return $update;
    }

    $method = $_SERVER["REQUEST_METHOD"];

    switch ($method) {
        case 'POST':
            try {    

        
                if (isset($_POST["id"]) && strlen($_POST["id"]) >= 1) {
                    $id = $_POST["id"];
                    $insert = setFields($_POST);
                    $sql = "UPDATE MODEL SET $insert WHERE ID = $id ";                     

                } else {

                    $name = $_POST["name"];
                    $code = $_POST["code"];
                    $description = $_POST["description"];
                    $id_brand = $_POST["brand"];

    
                    $sql = "INSERT INTO MODEL 
                    (name, code, description, id_brand) VALUES 
                    ('$name', '$code', '$description', '$id_brand')"; 
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

            $sql = "DELETE FROM MODEL WHERE ID = '$id'";

            $result = mysqli_query($connect, $sql) or die ("Erro ao deletar marca");

            $response["success"] = $result;

            echo json_encode($response);
            break;
        case 'GET':
            if (isset($_GET["type"])) {
                $sql = "SELECT * FROM BRAND";
                $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
                $brands = [];
            
                $brands = array();
                while( $data = mysqli_fetch_assoc($result) ) {
                    $brands[] = $data;
                }
                exit(json_encode($brands));
            } else {
                if (isset($_GET["keyword"]) && $_GET["keyword"] != NULL) {
                    $key = $_GET["keyword"];
                    $sql = "SELECT M.id, M.name, M.code, M.description, B.id as id_brand, B.name as name_brand
                            FROM MODEL as M, BRAND as B 
                            WHERE NAME LIKE '%$key%' OR CODE LIKE '%$key%' OR DESCRIPTION LIKE '%$key%'";
                } else {
                    $sql = "SELECT M.id, M.name, M.code, M.description, B.id as id_brand, B.name as name_brand
                            FROM MODEL as M, BRAND as B";
                }
                
                $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados do modelo");
            
                $models = [];
            
                $models = array();
                while( $data = mysqli_fetch_assoc($result) ) {
                    $models[] = $data;
                }
                echo json_encode($models);
            }

        
            break;
        
    }



