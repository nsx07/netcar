<?php 
    require '../../database/connection_db.php';
    session_start();

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT name, surname, email, password from user where email = '$email'";
    $result = mysqli_query($connect, $sql);
    $response["success"] = false;

    if (mysqli_num_rows($result) > 0) {
        $response["email"] = true;
        $row = mysqli_fetch_assoc($result);
        if (base64_decode($row["password"]) == $password) {
            $response["password"] = true;
            $response["success"] = true;

            $response["name"] = $row["name"];
            $response["surName"] = $row["surname"];

        } else {
            $response["password"] = false;
            $response["success"] = false;
        }
    } else {
        $response["email"] = true;
    }

    $_SESSION['name'] = isset($response["name"]) ? $response["name"] : NULL; 
    $_SESSION['surName'] = isset($response["surName"]) ? $response["surName"] : NULL; 

    echo json_encode($response);
?>