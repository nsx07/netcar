<?php 
    require '../../database/connection_db.php';

    if (isset($_GET)) {
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
    } else if (isset($_POST)) {

        $name = $_POST["name"];
        $birthDate = $_POST["birthDate"];
        $cpf = $_POST["cpf"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $password = $_POST["password"];
        $surname = $_POST["surname"];
        $id_access = $_POST["id_access"];

        
        $result = mysqli_query($connect, $sql) or die("Erro ao salvar carro");
    

    
        echo json_encode($result);
    }



