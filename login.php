<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Login </title>
    <link rel="stylesheet" href="style.css">
    <source src="index.js" type="text/js">
</head>
<body>
    <div class="vw-100 vh-100 d-flex justify-content-center align-items-center bg-dark">

        <div class="w-50 v-25 p-4 shadow bg-body-secondary rounded-3">
        
        <form>
            <div class="text-center">
                <h2>Login</h2>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="email" class="form-control" id="exampleInputEmail1" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="vendas@netcar.com" aria-describedby="emailHelp" required>
            </div>  
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Senha</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="ex: Netcar@2003$_" required>
            </div>
            <button type="submit" class="btn w-100 btn-primary">Entrar</button>
        </form>
        

        </div>

    </div>
</body>
</html>
