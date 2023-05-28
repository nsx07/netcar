<?php 
    require '../../database/connection_db.php';
    require '../../services/ImageService.php';
    session_start();

    function setFields($post) {
        $update = "";
        $itens = array();
        foreach ($post as $field => $value) {
            # code...     
            if ($field == "id" || $field == "name" || $field == "flexRadioDefault") continue;

            if ($field == "model") $field = "id_model";

            if ($field == "item") {
                array_push($value);
                continue;
            }
            
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
        case "PUT":
            if (isset($_PUT['deleteImgPath'])) {
                

                $imgPath = $_PUT['deleteImgPath'];

                $response = deleteImage($imgPath);
                
                exit(json_encode($response));
            }


            echo $_PUT['deleteImgPath'];

            break;
        case 'POST':
            try {   
            
                $serializedData = $_POST['data'];
                parse_str($serializedData, $formData);

                $upload = array();
                $id = NULL;
                if (isset($formData["id"]) && strlen($formData["id"]) >= 1) {

                    $id = $formData["id"];
                    $insert = setFields($formData);
                    $sql = "UPDATE CAR SET $insert WHERE ID = $id ";

                    if (isset($id) && isset($_FILES["images"])) {
                        $upload = saveImages($id, "cars", $_FILES["images"]);
                    }

                } else {
                    //insert
                    $year = $formData["year"];
                    $price = $formData["price"];
                    $kilometer = $formData["kilometers"];
                    $fuel = $formData["fuel"];
                    $color = $formData["color"];
                    $id_model = $formData["model"];

                    $sql = "INSERT INTO CAR
                    (`id_model`, `price`, `fuel`, `year`, `kilometers`, `color`) VALUES
                    ($id_model, cast($price as float), '$fuel', '$year', $kilometer, '$color')";

                    $row = mysqli_query($connect ,$sql);
                    $id = mysqli_insert_id($connect); 

                    if (isset($id) && isset($_FILES["images"])) {
                        $upload = saveImages($id, "cars", $_FILES["images"]);
                    }
                }
                

                $response["success"] = true;
                $response["query"] = $sql;
                $response["upload"] = $upload;
                
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

            $response["deleteImages"] = deleteImages($id, "cars");
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
                            WHERE M.NAME LIKE '%$key%' or C.YEAR LIKE '%$key%' ";
                } else {
                    $sql = "SELECT C.id as id, C.id_model as id_model, M.code as code, C.price as price, C.fuel as fuel, C.year as year,  C.kilometers as kilometers, C.color as color, M.name as name  FROM CAR AS C INNER JOIN MODEL AS M ON C.id_model = M.id";
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



