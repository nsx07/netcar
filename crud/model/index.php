<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="model.css">
    <?php require_once '../../utils/modules.php' ?>
    <script src="model.js"></script>
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
        <div class="card rounded p-2 mt-3 mx-5">
            <form id='search' onsubmit="return false" target="_self">
                <div class="row grid-items-center px-2">
                    <div class="col-6 flex align-items-center gap-2">
                        <i class="fa-solid fa-user fa-2x"></i>
                        <h3 class="font-medium font-xl m-0">Modelos</h3>
                        <button class="btn btn-sm text-white bg-default" id="new" data-bs-toggle="modal" data-bs-target="#formModal">
                            NOVO
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                    <div class="col-6">
                        <div class="input-group">
                            <input type="text" class="form-control border-none w-75 bg-gray-200"  id="keyword" name="keyword" placeholder="Pesquisar"> 
                            <span class="input-group-text border-none" id="searchBtn" > <i class="fa-solid fa-search"></i> </span>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card rounded p-4 mx-5">
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
    
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="formModalLabel">Cadastrar usuário</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="name">Nome <span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="name" pattern="[a-zA-Z]{3,}" name="name" placeholder="Digite aqui seu nome completo" required>
                    <small class="feedbackname fs-6 text text-danger"></small>
                </div>
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="surName">Sobrenome <span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="surName" pattern="[a-zA-Z]{3,}" name="surName" placeholder="Digite aqui seu nome completo" required>
                    <small class="feedbacksurName fs-6 text text-danger"></small>
                </div>
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="dateBirth">Data de nascimento <span style="color: red"> *</span></label>
                    <input type="date" class="form-control" id="dateBirth" name="dateBirth" placeholder="Informe sua data de nascimento" required>
                    <small class="feedbackdateBirth fs-6 text text-danger"></small>
                </div>
                <div class="col-md-6 col-sm-12 mt-2">                
                    <label for="email">Endereço de email <span style="color: red"> *</span></label>
                    <input type="email" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Seu melhor email" required>                    
                    <small class="feedbackemail fs-6 text text-danger"></small>
                </div>
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="cpf">CPF <span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" placeholder="Ex: 000.000.000-00" onkeyup="this.value = mascaraCPF(this.value)" required>
                    <small class="feedbackcpf fs-6 text text-danger"></small>
                </div>
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="phone">Telefone <span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="phone" name="phone" maxlength="15" placeholder="Ex: (DD) 9 9999-9999" onkeyup="this.value = mascaraTelefone(this.value)" required>
                    <small class="feedbackphone fs-6 text text-danger"></small>
                </div>  

                <div class="col mt-2">
                    <label for="id_access">Tipo de usuário</label>
                    <select class="form-select" id="id_access">
                      <option selected disabled>Selecione o tipo </option>
                      <option value="1">Admin</option>
                      <option value="2">Cliente</option>

                    </select>
                </div>
                                
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="password">Senha <span style="color: red"> *</span></label>
                    <input type="password" class="form-control" id="password" minlength="6" name="password" placeholder="Senha" required>
                    <small class="feedbackpassword fs-6 text text-danger"></small>
                </div>              
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="confirmPass">Confirmar senha <span style="color: red"> *</span></label>
                    <input type="password" class="form-control" id="confirmPass" minlength="6" name="confirmPass" placeholder="Confirmar senha" required>
                    <small class="feedbackconfirmPass fs-6 text text-danger"></small>
                </div>
                

            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn bg-default text-white" id="signup-button" type="button" disabled>
            <span id="default">
            Cadastrar
            </span> 
            <span id="loading" class="d-none">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Cadastrando...
            </span>
            
        </button>
      </div>
    </div>
  </div>
</div>
</body>
</html>