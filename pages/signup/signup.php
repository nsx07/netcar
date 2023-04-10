<?php 
    require '../database/connection_db.php';

    $name = $_POST["name"];
    $birthDate = $_POST["dateBirth"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $cep = 00000000;
    $addressNumber: 00;
    $id_access: 2;

    $sql = 
    "INSERT INTO user ('id_access','$name','surname','birthDate','email','cpf','phone','cep','addressNumber','password')
    values ('$id_access','$name','$surname','$birthDate','$email','$cpf','$phone','$cep','$addressNumber','$password')
    ";

    mysql_query($sql) or die (error());
    $response = array("success" => true);
    echo json_encode($response);

?>