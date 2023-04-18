<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros | netcar</title>
    <link rel="icon" type="image" href="../assets/logo-minify-purple.png">
    <?php require_once '../utils/modules.php' ?>
</head>
<body>

    <?php 
        session_start();
        
        require_once '../components/nav.php';
        if (!isset($_SESSION["name"])) {
            header("Location: /netcar/pages/login");
        }
        
        if ($_SESSION["id_access"] != 1) {
            header("Location: /netcar/pages/mainpage");
        }
    ?>

    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div id="conteudo">

        <div class="flex justify-content-start m-2 align-items-center">
            <h3 class="font-semibold">
                <i class="fa-solid fa-list"></i>
                Cadastros
            </h3>
        </div>

        <div class="flex justify-content-center gap-2 align-items-center p 4">
            <a href="users" class="btn bg-primary bg-gray-300 text-white" role="button">
                Users
                <i class="fa-solid fa-user"></i>
            </a>
            <a href="cars" class="btn bg-primary bg-gray-300 text-white" role="button">
                Cars
                <i class="fa-solid fa-car"></i>
            </a>
        </div>
            <!-- <div class="card rounded bg-gray-400 p-2">
            </div>
            <div class="card rounded bg-gray-400 p-2">
        </div> -->

    </div>
    
</body>
</html>