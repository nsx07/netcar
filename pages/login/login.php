<?php 
    require '../../database/connection_db.php';
    session_start();

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, id_access, name, surname, email, password from user where email = '$email'";
    $result = mysqli_query($connect, $sql);
    $response["success"] = false;

    if (mysqli_num_rows($result) > 0) {
        $response["email"] = true;
        $row = mysqli_fetch_assoc($result);
        if (base64_decode($row["password"]) == $password) {
            $response["password"] = true;
            $response["success"] = true;

            $response["name"] = $row["name"];
            $response["surname"] = $row["surname"];

            $response["id"] = $row["id"];
            $_SESSION["id"] = $row["id"];
            $_SESSION["id_access"] = $row["id_access"];

        } else {
            $response["password"] = false;
            $response["success"] = false;
        }
    } else {
        $response["email"] = false;
    }

    $_SESSION['name'] = isset($response["name"]) ? $response["name"] : NULL; 
    $_SESSION['surname'] = isset($response["surname"]) ? $response["surname"] : NULL; 
    $_SESSION["time"] = time();
    $_SESSION["max_time"] = isset($_SESSION["id_access"]) && $_SESSION["id_access"] == 1 ? 3600 : 1800; 
    $_SESSION["result"] = [$result, mysqli_num_rows($result)];
    
    
    echo json_encode($response);
?>