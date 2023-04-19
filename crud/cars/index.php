<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="cars.css">
    <?php require_once '../../utils/modules.php' ?>
    <script src="cars.js"></script>
</head>
<body>
    <?php 
        session_start();
        
        require_once '../../components/nav.php';
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


    <div id="conteudo" class="flex flex-column justify-content-center gap-3 vw-100">
        <div class="card rounded p-2 mt-3 mx-8">
            <form id='search' onsubmit="return false" target="_self">
                <div class="row grid-items-center px-2">
                    <div class="col-4 flex align-items-center gap-2">
                        <i class="fa-solid fa-car fa-2x"></i>
                        <h3 class="font-medium font-xl m-0">Carros</h3>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Pesquisar">
                    </div>
                    <div class="col-2">
                        <button id="searchBtn" class="btn bg-default text-white">
                            Buscar
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card rounded p-4 mx-8">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Sobrenome</th>
                        <th scope="col">Email</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">CPF</th>
                        <th colspan=2 scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody id='result'>
                </tbody>
            </table>
        </div>
    </div>
    
</body>
</html>