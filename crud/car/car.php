<?php 
    require '../../database/connection_db.php';
    session_start();

    function setFields($post) {
        $update = "";
        foreach ($post as $field => $value) {
            # code...     
            if ($field == "id" || $field == "name") continue;
            
            $update = $update . " `$field` = '$value'," ;

        }
        
        $update = substr($update, 0, -1);
           
        return $update;
    }

    function handleFiles($files) {
        
    }

    $method = $_SERVER["REQUEST_METHOD"];
    $_SESSION["time"] = time();

    switch ($method) {
        case 'POST':
            try {    

                if (isset($_POST["id"]) && strlen($_POST["id"]) >= 1) {

                    $id = $_POST["id"];
                    $insert = setFields($_POST);
                    $sql = "UPDATE CAR SET $insert WHERE ID = $id ";  
                } else {
                    //insert
                    $year = $_POST["year"];
                    $price = $_POST["price"];
                    $kilometer = $_POST["kilometers"];
                    $fuel = $_POST["fuel"];
                    $color = $_POST["color"];
                    $id_model = $_POST["model"];

                    

                    $sql = "INSERT INTO CAR
                    (`id_model`, `price`, `fuel`, `year`, `kilometers`, `color`) VALUES
                    ($id_model, cast($price as float), '$fuel', '$year', $kilometer, '$color')";
                }
                               
                
                $row = mysqli_query($connect ,$sql);
                $response["success"] = true;
                $response["query"] = $sql;
                
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
            if (isset($_GET["type"]) && $_GET["type"] == "resources" ) {

                $entities = ["model", "item"];
                $response = array();

                foreach ($entities as $entity) {
                    $sql = "SELECT * FROM $entity";
                    $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
                    $temp = array();    
                    
                    while( $data = mysqli_fetch_assoc($result) ) {
                        array_push($temp, $data);
                    }

                    $response[$entity] = $temp;
                }

                echo json_encode($response);
                // exit("Exit");
            } else {
                if (isset($_GET["keyword"]) && !empty($_GET["keyword"])) {
                    $key = $_GET["keyword"];
                    $sql = "SELECT C.id as id, C.id_model as id_model, M.code as code, C.price as price, C.fuel as fuel, C.year as year,  C.kilometers as kilometers, C.color as color, M.name as name  FROM CAR AS C INNER JOIN MODEL AS M ON C.id_model = M.id
                            WHERE M.NAME LIKE '%$key%' or C.NAME LIKE '%$key%' or C.YEAR ";
                } else {
                    $sql = "SELECT C.id as id, C.id_model as id_model, M.code as code, C.price as price, C.fuel as fuel, C.year as year,  C.kilometers as kilometers, C.color as color, M.name as name  FROM CAR AS C INNER JOIN MODEL AS M ON C.id_model = M.id";
                }
                
                $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
                        
                $cars = array();
                while( $data = mysqli_fetch_assoc($result) ) {
                    $cars[] = $data;    
                }
            
                echo json_encode($cars);
                break;
            }



        
    }



