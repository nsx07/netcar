<?php 
    require '../../database/connection_db.php';
    session_start();

    $method = $_SERVER["REQUEST_METHOD"];
    $_SESSION["time"] = time();

    switch ($method) {
        case 'POST':
            try {    

                if (isset($_POST["id"]) && strlen($_POST["id"]) >= 1) {

 
                } else {

                }
                               
                
             
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
            } else {

                if (isset($_GET["id"]) && !empty($_GET["id"])) {
                    $id = $_GET["id"];
                    $sql = "SELECT C.color as color, C.id as id, M.name as modelName, B.name as brandName, C.year as year, C.kilometers as kilometers, B.name as brand, C.price as price 
                            FROM CAR AS C INNER JOIN MODEL AS M ON C.id_model = M.id INNER JOIN BRAND AS B ON M.id_brand = B.id
                            WHERE C.id = $id ";
                            
                    $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
                            
                    $car = array();
                    while( $data = mysqli_fetch_assoc($result) ) {
                        $car[] = $data;    
                    }
                
                    echo json_encode($car);
                    break;
                }
                
            }
    }


    // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['images'])) {    
    //     require_once "../../services/ImageService.php";
    //     saveImages($_SESSION["id"], "profile", $_FILES['images']);
        
    // }
    ?>