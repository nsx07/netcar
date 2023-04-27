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

        <div class="flex justify-content-center p-2">
            <div class="row row-gap-2 p-2 w-75">
                <div class="col-12 text-center">
                    <h3 class="font-semibold">
                        <i class="fa-solid fa-list"></i>
                        Cadastros
                    </h3>
                </div>
                <div class="col-sm-12 col-md-6">
                    <button onclick="location.assign(location.origin + '/netcar/crud/users')" class="btn bg-primary bg-gray-300 text-white w-100" role="button">
                        <span class="text-base">Usuários</span>
                        <i class="fa-solid fa-user ml-2"></i>
                    </button>
                </div>
                <div class="col-sm-12 col-md-6">
                    <button onclick="location.assign(location.origin + '/netcar/crud/car')" class="btn bg-primary bg-gray-300 text-white w-100" role="button">
                        <span class="text-base">Carros</span>
                        <i class="fa-solid fa-car-side ml-2"></i>
                    </button>
                </div>
                <div class="col-sm-12 col-md-6">
                    <button onclick="location.assign(location.origin + '/netcar/crud/model')" class="btn bg-primary bg-gray-300 text-white w-100" role="button">
                        <span class="text-base">Modelos</span>
                        <i class="fa-solid fa-car-on ml-2"></i>
                    </button>
                </div>
                <div class="col-sm-12 col-md-6">
                    <button onclick="location.assign(location.origin + '/netcar/crud/brand')" class="btn bg-primary bg-gray-300 text-white w-100" role="button">
                        <span class="text-base">Marcas</span>
                        <i class="fa-solid fa-briefcase ml-2"></i>
                    </button>
                </div>
                <div class="col-sm-12 col-md-6">
                    <button onclick="location.assign(location.origin + '/netcar/crud/items')" class="btn bg-primary bg-gray-300 text-white w-100" role="button">
                        <span class="text-base">Items</span>
                        <i class="fa-solid fa-list ml-2"></i>
                    </button>
                </div>

            </div>
        </div>


    </div>
    
</body>
</html>