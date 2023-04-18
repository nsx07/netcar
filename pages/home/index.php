<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="home.css">    
    <script src="https://cdn.jsdelivr.net/npm/typeit@8.7.1/dist/index.umd.min.js"></script>
    <script src="home.js"></script>
</head>
<body>
    <?php require_once '../../utils/modules.php' ?>
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div id="conteudo" class="wrapper">
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column opacity-100">
            <header class="mb-auto ">
                <a class="navbar-brand flex justify-content-center align-items-center" href="../../index.php">
                    <img id="logoHeader"  src="../../assets/netcar-ban.png">
                </a>
                
                <div class="flex justify-content-center mt-2">
                    <div class="row">
                        <a class="col-3 col-sm-12 text-white w-max" href="../mainpage/">Buscar meu carro</a>
                        <a class="col-3 col-sm-12 text-white w-max" href="../login/">Logar</a>
                        <a class="col-3 col-sm-12 text-white w-max" href="../signup/">Cadastre-se</a>
                    </div>
                </div>

            </header>

            <main class="my-auto">
                <div class="text-center bg-type rounded p-2">

                    <h1 id="netcar" class="text-white font-medium"> Permita-se </h1>

                    <p id="copy" class="text-white font-medium text-lg"></p>
                </div>
            </main>

            <footer class="mt-auto text-center">
                <span class="text-white text-base p-2">&copy; 2023 NETCAR. Todos os direitos reservados.</span>
            </footer>
        </div>
        
    </div>
    
</body>
</html>