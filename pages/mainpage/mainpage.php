<?php 
    require '../../database/connection_db.php';
    require '../../services/ImageService.php';
    session_start();

    function setFields($post) {
        $update = "";
        $itens = array();
        foreach ($post as $field => $value) {


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
            }          
            else {
                $sql = "SELECT C.color as color, C.id as id, M.name as modelName, B.name as brandName, C.year as year, C.kilometers as kilometers, B.name as brand, C.price as price , it.name
                FROM CAR AS C INNER JOIN MODEL AS M ON C.id_model = M.id INNER JOIN BRAND AS B ON M.id_brand = B.id LEFT JOIN car_itens AS CI ON C.id = CI.id_car";   
                // LEFT OUTER JOIN item as IT ON CI.id_item = IT.id

                $keyName = isset($_GET["name"]) ? $_GET["name"] : null;
                //$keyBrand = isset($_GET["brands"]) ? $_GET["brands"] : null;

                if(isset($_GET["name"]) && !empty($_GET["name"])){
                    $sql = $sql . "WHERE M.NAME LIKE '%$keyName%' or B.NAME LIKE '%$keyName%'";
                }
                
                $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
                        
                $cars = array();
                while( $data = mysqli_fetch_assoc($result) ) {
                    $imgs = getImages($data["id"],"cars");

                    $data["images"] = $imgs;
    
                    $cars[] = $data;    
                }
            
                echo json_encode($cars);
                break;
            }



        
    }



