<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="users.css">
    <?php require_once '../../utils/modules.php' ?>
    <script src="users.js"></script>
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
        <form id='search' onsubmit="return false" target="_self">
            <div class="card p-2 flex flex-row justify-content-end gap-2 bg-white my-3 mx-8">
                <input type="id" class="form-control" id="id" name="id" placeholder="Id">
                <button id="search" class="btn bg-default text-white">
                    Buscar
                    <i class="fa fa-search"></i>
                </button>
            </div>

        </form>

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