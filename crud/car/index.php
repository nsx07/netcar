<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carros | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="car.css">
    <?php require_once '../../utils/modules.php' ?>
    <script src="car.js"></script>
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
                        <i class="fa-solid fa-car-side fa-2x"></i>
                        <h3 class="font-medium font-xl ml-2">Carros</h3>
                    </div>                    
                </div>
                <div class="col-md-6 col-sm-12 flex align-items-center justify-content-end">
                    <form id='search' onsubmit="return false" target="_self" class="my-2 w-100">
                        <div class="input-group" title="Pesquisar">
                            <input type="text" class="form-control border-none bg-gray-200"  id="keyword" name="keyword" placeholder="Pesquisar"> 
                            <span class="input-group-text border-none"> <i class="fa-solid fa-search"></i> </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow rounded p-4 mx-5">
            <div class="flex justify-content-start align-items-center gap-3 mb-2">
                <button class="btn btn-sm text-white bg-default" onclick="newEntity()" data-bs-toggle="tooltip" title="Adicionar novo carro">
                    NOVO
                    <i class="fa-solid fa-plus"></i>
                </button>

            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped rounded">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="valign-center text-center font-normal">#</th>
                            <th class="valign-center text-center font-normal">Banner</th>
                            <th class="valign-center text-center font-normal">Nome</th>
                            <th class="valign-center text-center font-normal">Modelo</th>
                            <th class="valign-center text-center font-normal">Combustível</th>
                            <th class="valign-center text-center font-normal">KM</th>
                            <th class="valign-center text-center font-normal">Ano</th>
                            <th class="valign-center text-center font-normal">Preço</th>
                            <th class="valign-center text-center font-normal">Cor</th>
                            <th class="valign-center text-center font-normal">Ações</th>
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
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="formModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <h3>Dados</h3>
                    <form id="form" onsubmit="return false"  target="_self">
                    <input type="text" id="id" name="id" class="d-none">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="model">Modelo <span style="color: red"> *</span></label>
                            <select class="form-select" id="model" name="model">
                            <option value="0" selected disabled>Selecione o modelo</option>
                            </select>
                            <small class="feedbackmodel fs-6 text text-danger"></small>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label for="year">Ano <span style="color: red"> *</span></label>
                            <input type="number" class="form-control" min="1950" max="2050" step="1" name="year" id="year" placeholder="2023"/>
                            <small class="feedbackyear fs-6 text text-danger"></small>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label for="price">Preço <span style="color: red"> *</span></label>
                            <div class="input-group mb-3 w-100">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                <input type="number" class="form-control" min="0" step="100" name="price" id="price" placeholder="1000"/>
                                <small class="feedbackprice fs-6 text text-danger"></small>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label for="kilometers">KM <span style="color: red"> *</span></label>
                            <div class="input-group mb-3 w-100">
                                <input type="number" class="form-control" min="0" step="1" name="kilometers" id="kilometers" placeholder="1000"/>
                                <small class="feedbackkilometers fs-6 text text-danger"></small>
                                <span class="input-group-text" id="basic-addon1">KM</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <label for="fuel">Combustível <span style="color: red"> *</span></label>
                            <select class="form-select" id="fuel" name="fuel">
                            <option value="0" selected disabled>Selecione o combustível</option>
                            </select>
                            <small class="feedbackfuel fs-6 text text-danger"></small>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="flex align-items-center jusitfy-content-center gap-2">
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" onclick="toggleColorSelector('picker')">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    RGB
                                </label>
                                </div>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" onclick="toggleColorSelector('select')" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Selecionar
                                </label>
                                </div>
                            </div>

                            <div id="colorInput">
                                <label for="color">Cor <span style="color: red"> *</span></label>
                                
                            </div>
                            <small class="feedbackitem fs-6 text text-danger"></small>

                        </div>

                        <div class="col-12">
                            <label for="item">Itens <span style="color: red"> *</span></label>
                            <div class="dropdown" style="width: 100% !important">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Selecione os itens
                                </button>
                                <div class="dropdown-menu p-2">
                                    <div class="grid" id="item"></div>
                                </div>
                            </div>
                            
                            <div class="w-full p-2 grid gap-2 mt-2" id="item-list"></div>
                            <input type="hidden" name="itens" id="itens" value="">

                            <small class="feedbackitem fs-6 text text-danger"></small>
                        </div>

                        <input class="d-none" type="file" id="images" name="images" onchange="showPreview(event)" accept="image/*" multiple>

                    </div>

                    <div class="p-2 border-none" id="images-container">
                        <p class="text-semibold font-2xl text-left">Imagens</p>
                        <div class="flex align-items-center justify-content-end">
                            <button class="btn btn-sm btn-danger" onclick="deleteImage()">
                                <span class="text-md font-medium text-white">Excluir imagem</span>
                                <i class="fa-solid fa-trash ml-2"></i>
                            </button>
                        </div>
                        <div class="flex align-items-center justify-content-center p-3" id="carousel-images"></div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close" data-bs-dismiss="modal">Fechar</button>
                <button class="btn bg-default text-white" id="save" type="button" >
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