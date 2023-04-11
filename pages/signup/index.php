<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Cadastro </title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="../../style.css">
</head>
<body class="bg-dark">
    <div class="vw-100 vh-100">
        
        <?php require '../../components/nav.php';?>

        <div class="container-fluid">

            <div class="row flex align-items-center justify-content-center p-2 m-2">
                <div class="col-lg-6 col-sm-12 shadow bg-body-secondary rounded-3 p-4">
                    <h3 class="text-center">Cadastro</h3>
                    <form id="signup" onsubmit="return false" target="_self">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 mt-2">
                                <label for="name">Nome Completo <span style="color: red"> *</span></label>
                                <input type="text" class="form-control" id="name" pattern="[a-zA-Z]{3,}" name="name" placeholder="Digite aqui seu nome completo" required>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">
                                <label for="surName">Sobrenome <span style="color: red"> *</span></label>
                                <input type="text" class="form-control" id="surName" pattern="[a-zA-Z]{3,}" name="surName" placeholder="Digite aqui seu nome completo" required>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">
                                <label for="dateBirth">Data de nascimento <span style="color: red"> *</span></label>
                                <input type="date" class="form-control" id="dateBirth" name="dateBirth" placeholder="Informe sua data de nascimento" required>
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">                
                                <label for="email">Endereço de email <span style="color: red"> *</span></label>
                                <input type="email" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Seu melhor email" required>                    
                            </div>
                            <div class="col-md-6 col-sm-12 mt-2">
                                <label for="cpf">CPF <span style="color: red"> *</span></label>
                                <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" placeholder="Ex: 000.000.000-00" onkeyup="this.value = mascaraCPF(this.value)" required>
                            </div>
                            <div class="col-12 col-sm-12 mt-2">
                                <label for="phone">Telefone <span style="color: red"> *</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" maxlength="15" placeholder="Ex: (DD) 9 9999-9999" onkeyup="this.value = mascaraTelefone(this.value)" required>
                            </div>

                            <!-- <div class="col-md-6 col-sm-6">
                                <label for="cep">CEP <span style="color: red"> *</span></label>
                                <input type="text" class="form-control" id="cep" name="cep" maxlength="9" onkeyup="handleZipCode(event)" placeholder="Ex: 80000-000" required>
                            </div>
                            <div class="col-12">
                                <label for="street">Rua</label>
                                <input type="text" class="form-control" id="street" name="street" readonly>
                            </div>
                            <div class="col-4">
                                <label for="city">Cidade</label>
                                <input type="text" class="form-control" id="city" name="city" readonly>
                            </div>
                            <div class="col-4">
                                <label for="state">Estado</label>
                                <input type="text" class="form-control" id="state" name="state" readonly>
                            </div>
                            <div class="col-md-6 col-sm-3">
                                <label for="houseNumber">Número</label>
                                <input type="number" class="form-control" id="houseNumber" name="houseNumber" placeholder="Ex: 540">
                            </div>
                            
                            <div class="col-md-6 col-sm-3">
                                <label for="complement">Complemento</label>
                                <input type="number" class="form-control" id="complement" name="complement" placeholder="Ex: ap 301">
                            </div> -->
                                
                            <div class="col-md-6 col-sm-12 mt-2">
                                <label for="password">Senha <span style="color: red"> *</span></label>
                                <input type="password" class="form-control" id="password" minlength="6" name="password" placeholder="Senha" required>
                            </div>              
                            <div class="col-md-6 col-sm-12 mt-2">
                                <label for="confirmPass">Confirmar senha <span style="color: red"> *</span></label>
                                <input type="password" class="form-control" id="confirmPass" minlength="6" name="confirmPass" placeholder="Confirmar senha" required>
                            </div>
                            
                            <div class="col-12 mt-2 d-flex justify-content-end">
                                <button class="btn bg-default text-white btn-lg w-100" id="signup-button" disabled>Cadastrar</button>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <small class="text-md font-medium text-center"><a href="../login/">Possui conta ? Faça Login!</a></small>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
            <script type="text/javascript" src="signup.js"></script>
        </div>
    </div>
</body>
</html>

