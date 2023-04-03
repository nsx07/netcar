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
        
        <?php require '../../components/nav.html';?>

        <div class="container-fluid">

            <div class="row flex align-items-center justify-content-center p-2 m-2">
                <div class="col-lg-6 col-sm-12 shadow bg-body-secondary rounded-3 p-4">
                    <h3 class="text-center">Cadastro</h3>
                    <form id="signup" onsubmit="return showData()">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="name">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Digite aqui seu nome completo" required>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="dateBirth">Data de nascimento</label>
                                    <input type="date" class="form-control" id="dateBirth" name="dateBirth" placeholder="Informe sua data de nascimento" required>
                                </div>
                                <div class="col-md-6 col-sm-12">                
                                    <label for="email">Endereço de email</label>
                                    <input type="email" class="form-control" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Seu melhor email" required>                    
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="cpf">CPF</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" placeholder="Ex: 000.000.000-00" onkeyup="this.value = mascaraCPF(this.value)" required>
                                </div>
                    
        
                                <div class="col-md-6 col-sm-12">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control" id="telefone" name="telefone" maxlength="15" placeholder="Ex: (DD) 9 9999-9999" onkeyup="this.value = mascaraTelefone(this.value)" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="cep">CEP</label>
                                    <input type="text" class="form-control" id="cep" name="cep" maxlength="9" onkeyup="handleZipCode(event)" placeholder="Ex: 80000-000" required>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <label for="numeroResidencia">Número</label>
                                    <input type="text" class="form-control" id="numeroResidencia" name="numeroResidencia" maxlength="5" placeholder="Ex: 540" required>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
                                </div>              
                                <div class="col-md-6 col-sm-12">
                                    <label for="confirmPass">Confirmar senha</label>
                                    <input type="password" class="form-control" id="confirmPass" name="confirmPass" placeholder="Confirmar senha" required>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-2 d-flex justify-content-end">
                                <script>
                                    const data = {};
                                    function showData() {
                                        const fields = ["name", "dateBirth", "email", "cpf", "telefone", "cep", "numeroResidencia","password","confirmPass"]
                                        const form = document.forms["signup"]
                                        

                                        fields.forEach(field => {
                                            data[field] = form[field].value;
                                            // console.log(field + ": " + form[field].value);
                                        })
                                        if (data.password !== data.confirmPass) {
                                            alert("Password dont match.")
                                        } else {
                                            alert(JSON.stringify(data))
                                        }


                                        return false;
                                    }

                                    function validPass() {
                                        console.log(data);
                                        if (data.password === data.confirmPass) {
                                            return true;
                                        }
                                        return false;
                                    }
                                </script>
                                <button class="btn bg-default text-white btn-lg w-100" id="signup-button">Cadastrar</button>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <small class="text-md font-medium text-center"><a href="../login/login.php">Possui conta ? Faça Login!</a></small>
                                
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

