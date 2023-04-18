<?php 
    require '../../database/connection_db.php';

    if (isset($_GET["id"]) && $_GET["id"] >= 1) {
        $id = $_GET["id"];
        $sql = "SELECT * FROM USER WHERE ID = '$id'";

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



