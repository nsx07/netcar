<script>sessionStorage.removeItem("user");</script>
<?php 
    require '../database/connection_db.php';
    
    session_unset();
    session_destroy();
    header("Location: ../");
    unset($_SESSION["name"]);
    unset($_SESSION["surName"]);
    unset($_SESSION["email"]);

    echo json_encode($res["message"] = "Turn off");

?>