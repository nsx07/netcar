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

    function handleFiles($files) {

    }

    $method = $_SERVER["REQUEST_METHOD"];

    switch ($method) {
        case 'POST':
            try {    

        
                if (isset($_POST["id"]) && strlen($_POST["id"]) >= 1) {
                    $id = $_POST["id"];
                    $insert = setFields($_POST);
                    $sql = "UPDATE CAR SET $insert WHERE ID = $id ";                     

                } else {
                    


                }
        
                // $row = mysqli_query($connect ,$sql);
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

            $sql = "DELETE FROM CAR WHERE ID = '$id'";

            $result = mysqli_query($connect, $sql) or die ("Erro ao deletar carro");

            $response["success"] = $result;

            echo json_encode($response);
            break;
        case 'GET':
            if (isset($_GET["type"]) && $_GET["type"] == "resource" ) {

                $sql = "SELECT * FROM BRAND, MODEL"
                $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
                    
                $response = array();
                while( $data = mysqli_fetch_assoc($result) ) {
                    $response[] = $data;
                }
                        
                echo json_encode($response);
                exit();
            }


            if (isset($_GET["keyword"]) && $_GET["keyword"] != NULL) {
                $key = $_GET["keyword"];
                $sql = "SELECT * FROM CAR 
                        WHERE ID = '$key' or NAME LIKE '%$key%' ";
            } else {
                $sql = "SELECT * FROM CAR";
            }
            
            $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
        
            $users = [];
        
            $users = array();
            while( $data = mysqli_fetch_assoc($result) ) {
                $users[] = $data;
            }
        
            echo json_encode($users);
            break;
        
    }



