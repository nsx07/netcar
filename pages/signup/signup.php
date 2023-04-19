<?php 
    session_start();
    require '../../database/connection_db.php';

    $name = $_POST["name"];
    $birthDate = $_POST["birthDate"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $surname = $_POST["surname"];
    $id_access = 2;

    try {
        $password = base64_encode($password);
        $cpf = str_replace([".", "-"], "", $cpf);
        $phone = str_replace(["(", ")", "-"], "", $phone);

        $sql = "INSERT INTO user 
        (id_access, name, surname, birthDate, email, cpf, phone, password) VALUES 
        ($id_access,'$name', '$surname', '$birthDate', '$email', '$cpf', '$phone', '$password')"; 

        $row = mysqli_query($connect ,$sql);

        $response["success"] = true;
        $response["query"] = $sql;
        $response["name"] = $name;
        $response["surname"] = $surname;
        $response["email"] = $email;
        $response["id"] = mysqli_insert_id($connect); 
    
        $_SESSION["id"] = mysqli_insert_id($connect);
        $_SESSION["id_access"] = $id_access;
        $_SESSION["name"] = $name;
        $_SESSION["surname"] = $surname;
        $_SESSION["time"] = time();
        $_SESSION["max_time"] = 1800;

        echo json_encode($response);
    } catch (\Throwable $th) {
        echo json_encode(mysqli_error($connect));
    }
?> 