<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Login </title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="bg-dark">
    <?php 
        session_start();
        require_once '../../utils/modules.php';
        require '../../components/nav.php';
        if (isset($_SESSION["name"])) {
            header("Location: ../mainpage/");
        } 

    ?>
    <div id="loader">
        <div class="spinner"></div>
    </div>

    <div id="conteudo" class="vw-100 vh-100">


        <div class="container-fluid">

            <div class="row flex justify-content-center align-items-center p-2 m-2">

                <div class="col-lg-6 col-md-8 col-sm-12 shadow bg-body-secondary rounded-3 p-4">
                    <h2 class="text-center">Login</h2>
                    <div class="row">
                        <form id="login" onsubmit="return false" target="_self">
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Ex: vendas@netcar.com" aria-describedby="emailHelp" required>
                            </div>  
                            <div class="col-12">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" pattern="[a-z0-9-A-Z-!@#_$%]{6}" name="password" placeholder="Pelo menos 6 digitos" required>
                            </div>
                            <div class="col-12 mt-2">
                                <button class="btn bg-default text-white btn-lg w-100" id="login-button" type="button" disabled>
                                  <span id="default">
                                    Entrar
                                  </span> 
                                  <span id="loading" class="d-none">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Entrando...
                                  </span>
                                  
                                </button>
                            </div>
                        </form>
                        <small class="text-md font-medium text-center"><a href="../signup/">Não possui conta ? Faça o cadastro!</a></small>
                    </div>
                </div>

            </div>
            <script type="text/javascript" src="login.js"></script>
        </div>
    </div>

</body>
</html>
