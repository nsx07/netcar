<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Cadastro </title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="../../style.css">
    <script src="signup.js"></script>
</head>
<body>
    <div class="vw-100 vh-100 bg-dark">

        <?php require '../../components/nav.html';?>

        <div class="h-100 mt-2 d-flex justify-content-center align-items-center">

            <div id="formModal" class="w-50 v-25 shadow bg-body-secondary rounded-3 p-4" style="margin-top:4rem">
                <h3 class="text-center">Cadastro</h3>
                <div class="grid">
                    <form>
                        <div class="row">
                            <div class="col-6">
                                <label for="exampleInputNomeCompleto">Nome Completo</label>
                                <input type="text" class="form-control" id="exampleInputNomeCompleto" aria-describedby="emailHelp" placeholder="Digite aqui seu nome completo" required>
                            </div>
                            <div class="col-6">
                                <label for="dateBirth">Data de nascimento</label>
                                <input type="date" class="form-control" id="dateBirth" aria-describedby="dateBirth" placeholder="Informe sua data de nascimento" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">                
                                <label for="email">Endereço de email</label>
                                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Seu melhor email" required>                    
                            </div>
                            <div class="col-6">
                                <label for="cpf">CPF</label>
                                <input type="text" class="form-control" id="cpf" maxlength="14" aria-describedby="emailHelp" placeholder="Ex: 000.000.000-00" onkeyup="this.value = mascaraCPF(this.value)" required>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-6">
                                <label for="telefone">Telefone</label>
                                <input type="text" class="form-control" id="telefone" maxlength="15" aria-describedby="emailHelp" placeholder="Ex: (DD) 9 9999-9999" onkeyup="this.value = mascaraTelefone(this.value)" required>
                            </div>
                            <div class="col-3">
                                <label for="cep">CEP</label>
                                <input type="text" class="form-control" id="cep" maxlength="9" onkeyup="handleZipCode(event)" aria-describedby="emailHelp" placeholder="Ex: 80000-000" required>
                            </div>
                            <div class="col-3">
                                <label for="numeroResidencia">Número</label>
                                <input type="text" class="form-control" id="numeroResidencia" maxlength="5" aria-describedby="emailHelp" placeholder="Ex: 540" required>
                            </div>
                            
                        <div class="row">
                            <div class="col-6">
                                <label for="exampleInputPassword1">Senha</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Senha" required>
                            </div>              
                            <div class="col-6">
                                <label for="exampleInputPassword2">Confirmar senha</label>
                                <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Confirmar senha" required>
                            </div>
                        </div>
    
                        <div class="col-12 mt-2 d-flex justify-content-end">
    
                            <button type="submit" class="btn bg-default text-white btn-lg w-100" onclick="showData(event)">Cadastrar</button>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <small class="text-md font-medium text-center"><a href="http://localhost/netcar/pages/login/login.php">Possui conta ? Faça Login!</a></small>
    
                        </div>
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
</body>
</html>

