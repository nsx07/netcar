<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="users.css">
    <?php require_once '../../utils/modules.php' ?>
    <script src="users.js"></script>
</head>
    <body>
        <?php 
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
            <div class="card shadow rounded p-3 mt-3 mx-5">
                <div class="row grid-items-center px-2 row-gap-2">
                    <div class="col-md-6 col-sm-12 flex-column align-items-center">
                        <div class="flex justify-content-start column-gap-1 my-2">
                            <i class="fa-solid fa-user fa-2x"></i>
                            <h3 class="font-medium font-xl m-0">Usuários</h3>
                        </div>                    
                    </div>
                    <div class="col-md-6 col-sm-12 flex align-items-center justify-content-end">
                        <form id='search' onsubmit="return false" target="_self" class="my-2 w-100">
                            <div class="input-group" data-bs-toggle="tooltip" title="Pesquisar">
                                <input type="text" class="form-control border-none bg-gray-200"  id="keyword" name="keyword" placeholder="Pesquisar"> 
                                <span class="input-group-text border-none"> <i class="fa-solid fa-search"></i> </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow rounded p-4 mx-5">
                <div class="flex justify-content-start align-items-center gap-3 mb-2">
                    <button class="btn btn-sm text-white bg-default" onclick="newEntity()" data-bs-toggle="tooltip" title="Adicionar novo usuário">
                        NOVO
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <div class="text-xs text-red-300 font-semibold">
                            <span>Super usuários só podem ser cadastrado por aqui.</span>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped rounded">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th class="valign-center text-center font-normal" scope="col">#</th>
                                <th class="valign-center text-center font-normal" scope="col">Nome</th>
                                <th class="valign-center text-center font-normal" scope="col">Sobrenome</th>
                                <th class="valign-center text-center font-normal" scope="col">Email</th>
                                <th class="valign-center text-center font-normal" scope="col">Telefone</th>
                                <th class="valign-center text-center font-normal" scope="col">CPF</th>
                                <th class="valign-center text-center font-normal" scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody id='result'>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <button class="d-none" id="modal" data-bs-toggle="modal" data-bs-target="#formModal"></button>
        
        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true" style="z-index:9999">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="formModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="signup" onsubmit="return false"  target="_self">
                    <input type="text" id="id" name="id" class="d-none">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 mt-2">
                            <label for="name">Nome <span style="color: red"> *</span></label>
                            <input autocomplete="name" type="text" class="form-control" id="name" pattern="[a-zA-Z]{3,}" name="name" placeholder="Seu primeiro nome" required>
                            <small class="feedbackname fs-6 text text-danger"></small>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2">
                            <label for="surname">Sobrenome <span style="color: red"> *</span></label>
                            <input autocomplete="name" type="text" class="form-control" id="surname" pattern="[a-zA-Z]{3,}" name="surname" placeholder="Seu sobrenome" required>
                            <small class="feedbacksurname fs-6 text text-danger"></small>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2">
                            <label for="birthDate">Data de nascimento <span style="color: red"> *</span></label>
                            <input autocomplete="name" type="date" class="form-control" id="birthDate" name="birthDate" placeholder="Informe sua data de nascimento" required>
                            <small class="feedbackbirthDate fs-6 text text-danger"></small>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2">                
                            <label for="email">Endereço de email <span style="color: red"> *</span></label>
                            <input autocomplete="name" type="email" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" placeholder="Seu melhor email" required>                    
                            <small class="feedbackemail fs-6 text text-danger"></small>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2">
                            <label for="cpf">CPF <span style="color: red"> *</span></label>
                            <input autocomplete="name" type="text" class="form-control" id="cpf" name="cpf" maxlength="14" placeholder="Ex: 000.000.000-00" onkeyup="this.value = mascaraCPF(this.value)" required>
                            <small class="feedbackcpf fs-6 text text-danger"></small>
                        </div>
                        <div class="col-md-6 col-sm-12 mt-2">
                            <label for="phone">Telefone <span style="color: red"> *</span></label>
                            <input autocomplete="name" type="text" class="form-control" id="phone" name="phone" maxlength="15" placeholder="Ex: (DD) 9 9999-9999" onkeyup="this.value = mascaraTelefone(this.value)" required>
                            <small class="feedbackphone fs-6 text text-danger"></small>
                        </div>  

                        <div class="col-12 mt-2">
                            <label for="id_access">Tipo de usuário</label>
                            <select class="form-select" id="id_access" name="id_access">
                                <option value="0" selected>Selecione</option>
                                <option value="1">Admin</option>
                                <option value="2">Cliente</option>
                            </select>
                            <small class="feedbackid_access fs-6 text text-danger"></small>
                        </div>
                                        
                        <div class="col-12 grid grid-nogutter p-2">

                            <div class="col-12 flex justify-content-center">

                                <span id="changePassDiv">
                                    <div class="form-check form-switch flex align-items-center gap-2">
                                        <input class="form-check-input" type="checkbox" role="switch" id="changePass" unchecked>
                                        <label class="form-check-label font-semibold text-xl" for="changePass">Deseja alterar a senha ? </label>
                                    </div>
                                </span>

                            </div>

                            <div class="col-md-6 col-sm-12">
                                <label for="password">Senha <span style="color: red"> *</span></label>
                                <input type="password" autocomplete="new-password" class="form-control" id="password" style="width: 95%" minlength="6" name="password" placeholder="Senha" required>
                                <small class="feedbackpassword fs-6 text text-danger"></small>
                            </div>              
                            <div class="col-md-6 col-sm-12">
                                <label for="confirmPass">Confirmar senha <span style="color: red"> *</span></label>
                                <input type="password" autocomplete="new-password" class="form-control" id="confirmPass" style="width: 95%" minlength="6" name="confirmPass" placeholder="Confirmar senha" required>
                                <small class="feedbackconfirmPass fs-6 text text-danger"></small>
                            </div>

                        </div>
                        

                    </div>
                    </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-secondary" id="close" data-bs-dismiss="modal">Fechar</button>
                <button class="btn btn-lg bg-default text-white" id="save" type="button" disabled>
                    <span id="default">
                    Salvar
                    </span> 
                    <span id="loading" class="d-none">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Salvando...
                    </span>
                    
                </button>
            </div>
            </div>
    </div>
    </div>
    </body>
</html>