<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Login </title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="../../style.css">
    <source src="login.js" type="text/js">
</head>
<body>
    <div class="vw-100 vh-100 bg-dark">

    <?php require '../../components/nav.html';?>

        <div class="h-100 d-flex justify-content-center align-items-center">
    
            <div class="p-4 shadow bg-body-secondary rounded-3">
                <h2 class="text-center">Login</h2>
                <div class="grid">
                    <form>
                        <div class="col-12">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="vendas@netcar.com" aria-describedby="emailHelp" required>
                        </div>  
                        <div class="col-12">
                            <label for="exampleInputPassword1" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="ex: Netcar@2003$_" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn w-100 bg-default text-white d-flex justify-content-center">Entrar</button>
                            <small class="text-md font-medium text-center"><a href="http://localhost/netcar/pages/signup/signup.php">Não possui conta ? Faça o cadastro!</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
