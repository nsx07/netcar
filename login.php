<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Login </title>
    <link rel="stylesheet" href="style.css">
    <script src="index.js"></script>
</head>
<body>
    <div class="vw-100 vh-100 d-flex justify-content-center align-items-center bg-dark">

        <div class="w-50 v-25 shadow bg-body-secondary rounded-3" style="padding-bottom: 50px; padding-left: 50px; padding-right: 50px; padding-top: 50px">
            <form>
                <br>
                <div class="form-group">
                    <label for="exampleInputNomeCompleto">Nome Completo</label>
                    <input type="text" class="form-control" id="exampleInputNomeCompleto" aria-describedby="emailHelp" placeholder="Digite aqui seu nome completo" required>
                </div>
                <br>
                <div class="form-group">                
                    <label for="email">Endereço de email</label>
                    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Digite seu email" required>                    
                </div>
                <br>               
                <div class="form-group">
                    <label for="exampleInputPassword1">Senha</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha" required>
                </div>              
                <br>
                <div class="form-group">
                    <label for="exampleInputPassword2">Confirmar senha</label>
                    <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Confirmar senha" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" id="cpf" maxlength="14" aria-describedby="emailHelp" placeholder="000.000.000-00" onkeyup="this.value = mascaraCPF(this.value)" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="telefone">Número de telefone</label>
                    <input type="text" class="form-control" id="telefone" maxlength="15" aria-describedby="emailHelp" placeholder="(DD) 9 9999-9999" onkeyup="this.value = mascaraTelefone(this.value)" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="cep">CEP</label>
                    <input type="text" class="form-control" style="width:150px" id="cep" maxlength="9" onkeyup="handleZipCode(event)" aria-describedby="emailHelp" placeholder="Codigo Postal" required>
                    <input type="text" class="form-control" style="width:170px" id="numeroResidencia" maxlength="5" aria-describedby="emailHelp" placeholder="Numero residência" required>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Cadastrar-se!</button>
            </form>
        </div>

    </div>
</body>
</html>

