<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Login </title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="../../style.css">
    <script src="login.js"></script>
</head>
<body class="bg-dark">
    <div class="vw-100 vh-100">

    <?php require '../../components/nav.html';?>
    <script>
    function showData() {
        const fields = ["email","password"]
        const form = document.forms["login"]
        const data = {};

        fields.forEach(field => {
            data[field] = form[field].value;
            console.log(field + ": " + form[field].value);
        })

        alert(JSON.stringify(data))
        return false;
    }
    </script>

        <div class="container-fluid">

            <div class="row flex justify-content-center align-items-center p-2 m-2">

                <div class="col-lg-6 col-md-8 col-sm-12 shadow bg-body-secondary rounded-3 p-4">
                    <h2 class="text-center">Login</h2>
                    <div class="row">
                        <form id="login" onsubmit="return showData()">
                            <div class="col-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="vendas@netcar.com" aria-describedby="emailHelp" required>
                            </div>  
                            <div class="col-12">
                                <label for="password" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="password" minLength="5" name="password" placeholder="ex: Netcar@2003$_" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn w-100 bg-default text-white d-flex justify-content-center">Entrar</button>
                            </div>
                        </form>
                        <small class="text-md font-medium text-center"><a href="../signup/signup.php">Não possui conta ? Faça o cadastro!</a></small>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
