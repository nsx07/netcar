<?php 
    require '../../database/connection_db.php';

    if (isset($_GET)) {
        if (isset($_GET["keyword"]) && $_GET["keyword"] != NULL) {
            $key = $_GET["keyword"];
            $sql = "SELECT * FROM USER 
                    WHERE ID = '$key' or NAME = '$key' OR SURNAME = '$key' OR EMAIL = '$key' OR CPF = '$key' OR PHONE = '$key'  ";
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
    }



