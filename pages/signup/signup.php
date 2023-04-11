<?php 
    require '../../database/connection_db.php';

    $name = $_POST["name"];
    $birthDate = $_POST["dateBirth"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $surname = $_POST["surName"];

    $id_access = 2;

    $password = base64_encode($password);

    $sql = "INSERT INTO user 
        (id_access, name, surname, birthDate, email, cpf, phone, password) VALUES 
        ($id_access,'$name', '$surname', '$birthDate', '$email', '$cpf', '$phone', '$password')"; 


    $row = mysqli_query($connect ,$sql) or throw new Exception("Error Processing Request '$sql'", 1);
    $response["success"] = true;
    $response["query"] = $sql;

    $response["name"] = $name;
    $response["surName"] = $surname;
    $response["email"] = $email;

    echo json_encode($response);
?>