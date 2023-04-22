<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcas | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="brand.css">
    <?php require_once '../../utils/modules.php' ?>
    <script src="brand.js"></script>
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
        <div class="card shadow rounded p-3 mt-3 mx-5">
            <div class="row grid-items-center px-2 row-gap-2">
                <div class="col-md-6 col-sm-12 flex-column align-items-center">
                    <div class="flex justify-content-start column-gap-1 my-2">
                        <i class="fa-solid fa-briefcase fa-2x"></i>
                        <h3 class="font-medium font-xl ml-2">Marcas</h3>
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

            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped rounded">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="valign-center text-center font-normal" scope="col">#</th>
                            <th class="valign-center text-center font-normal" scope="col">Nome</th>
                            <th class="valign-center text-center font-normal" scope="col">Código</th>
                            <th class="valign-center text-center font-normal" scope="col">Descrição</th>
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
    
    <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="formModalLabel"></h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="form" onsubmit="return false"  target="_self">
            <input type="text" id="id" name="id" class="d-none">
            <div class="row">
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="name">Nome <span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nome completo marca" required>
                    <small class="feedbackname fs-6 text text-danger"></small>
                </div>
                <div class="col-md-6 col-sm-12 mt-2">
                    <label for="code">Código <span style="color: red"> *</span></label>
                    <input type="text" class="form-control" id="code" name="code" placeholder="Código da marca" required>
                    <small class="feedbackcode fs-6 text text-danger"></small>
                </div>
                <div class="col-12 mt-2">
                    <label for="description">Descrição <span style="color: red"> *</span></label>
                    <textarea type="text" class="form-control" id="description" name="description" placeholder="Descrição da marca" required></textarea>
                    <small class="feedbackdescription fs-6 text text-danger"></small>
                </div>
            </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Close</button>
        <button class="btn bg-default text-white" id="save" type="button" disabled>
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