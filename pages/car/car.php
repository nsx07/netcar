<?php 
    require '../../database/connection_db.php';
    require '../../services/ImageService.php';
    session_start();

    $method = $_SERVER["REQUEST_METHOD"];
    $_SESSION["time"] = time();

    function parseItens($itens) {
        $itens = explode(",", $itens);

        if ($itens[0] == 0 || $itens[0] == '') {
            $itens = array();
        }

        return $itens;
    }

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
            
            if (isset($_GET["id"]) && !empty($_GET["id"])) {
                $id = $_GET["id"];
                $sql = "SELECT C.id as id, C.id_model as model, M.code as code, C.price as price, C.fuel as fuel, C.year as year,  C.kilometers as kilometers, C.color as color, M.name as name, B.name as brand, M.description as description,
                        (SELECT GROUP_CONCAT(i.name SEPARATOR ', ') FROM car_itens as ci INNER JOIN item i ON ci.id_item = i.id WHERE ci.id_car = C.id) AS itens FROM CAR AS C INNER JOIN MODEL AS M ON C.id_model = M.id  INNER JOIN BRAND AS B ON M.id_brand = B.id
                        
                        WHERE C.id = $id ";
                        
                $result = mysqli_query($connect, $sql) or die("Erro ao buscar dados de marca");
                        
                $car = array();
                while( $data = mysqli_fetch_assoc($result) ) {
                    $imgs = getImages($data["id"],"cars");

                    $data["images"] = $imgs;
    
                    $data["itens"] = parseItens($data["itens"]);
                    $car[] = $data;    
                }

                if (count($car) == 0) {
                    $car[] = null;
                }

                
            
                echo json_encode($car[0]);
                break;
            }

    }

    ?>