<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha seu carro | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="car.css">  
</head>
<body>
    <?php require '../../utils/modules.php'; ?>
    <script src="car.js"></script>
    
    <?php 
        require_once '../../components/nav.php';
        if (!isset($_SESSION["name"])) {
            header("Location: /netcar/pages/login");
        }
        ?>

    <div id="loader"> <div class="spinner"></div> </div>

    <div id="conteudo" class="grid gap-2 w-100 overflow-y-scroll m-0">

        <div class="col-12 d-none" id="notFound">
            <div class="flex align-items-center justify-content-center p-4">
                <div class="alert alert-warning" role="alert">
                    <h2 class="text-xl font-semibold">Carro não encontrado</h2>
                </div>
            </div>
        </div> 

        <div class="col-12 grid d-none w-screen" id="content">
            <div class="col-12 w-screen" id="carousel"></div>

            <div class="col-12 flex justify-content-center w-screen p-2 sm:px-4 md:px-8 md:mx-4">
                <div class="grid gap-2 w-full">
                    <div class="col-12 md:col-3 border-round-xl bg-white shadow-2" style="height:max-content">
                        <div class="flex justify-content-between align-items-center">
                            <span class="text-lg md:text-2xl font-semibold text-left m-2" id='carName'></span>
                            <span class="text-lg md:text-2xl font-semibold text-left m-2" id='carPrice'></span>
                        </div>
                        <div class="flex justify-content-between align-items-center">
                            <span class="text-sm md:text-xl text-left m-2"> Marca </span>
                            <span class="text-sm md:text-xl text-left m-2" id='carBrand'></span>
                        </div>
                        <div class="flex justify-content-between align-items-center">
                            <span class="text-sm md:text-xl text-left m-2"> Ano </span>
                            <span class="text-sm md:text-xl text-left m-2" id='carYear'></span>
                        </div>
                        <div class="flex justify-content-between align-items-center">
                            <span class="text-sm md:text-xl text-left m-2"> Kilometragem </span>
                            <span class="text-sm md:text-xl text-left m-2" id='carKM'></span>
                        </div>
                        <div class="flex justify-content-between align-items-center">
                            <span class="text-sm md:text-xl text-left m-2"> Cor </span>
                            <span class="text-sm md:text-xl text-left m-2" id='carColor'></span>
                        </div>
                    </div>
                    <div class="col-12 md:col-8 border-round-xl bg-white shadow-2">
                        <div class="grid">
                            <div class="col-12">
                                <span class="text-2xl text-left">Descrição</span><br>
                                <span id='carDescription'></span>
                            </div>
                            <div class="col-12">
                                <span class="text-2xl text-left">Itens do carro</span>
                                <div class="grid gap-2 p-2" id='carItens'></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>