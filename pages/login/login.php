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
        if ($row["password"] == $password) {
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

    unset($_SESSION["name"]);
    unset($_SESSION["surname"]);
    $_SESSION["name"] = $response["name"] ? $response["name"] : '';
    $_SESSION["surName"] = $response["surName"] ? $response["surName"] : '';


    echo json_encode($_SESSION);
?>