<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha seu carro | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="mainpage.css">  
</head>
<body>
    <?php require '../../utils/modules.php'; ?>
    <script src="mainpage.js"></script>
    
    <?php 
        
        require_once '../../components/nav.php';
        if (!isset($_SESSION["name"])) {
            header("Location: /netcar/pages/login");
        }
        ?>

    <div id="loader">
    <div class="spinner"></div>
    </div>

    <div id="conteudo" class="container-fluid py-3">
        <div class="col-12">
            <form id="filter" method="GET">                
                <div class="grid grid-nogutter">
                    <div class="p-2 md:col-4 sm:col-12 xs:col-12">
                        <div class="input-group w-100">
                            <span class="input-group-text border-none bg-white color-default" id="basic-addon1"> <i class="fa-solid fa-search"></i> </span>
                            <input type="text" class="form-control border-none " id="name" name="name" placeholder="Pesquise...">          
                        </div>                    
                    </div>
                    <div class="p-2 md:col-3 sm:col-6 xs:col-6">
                        <select class="form-select w-100" id="models" name="models" placeholder="Filtrar por modelo">
                            <option value="semFiltroModels" selected disabled>Filtrar por modelo</option>
                        </select>                    
                    </div>
                    <div class="p-2 md:col-3 sm:col-6 xs:col-6">
                        <select class="form-select w-100" id="brands" name="brands" placeholder="Filtrar por marca">
                            <option value="semFiltroBrands" selected disabled>Filtrar por marca</option>
                        </select>
                    </div>
                    <div class="p-2 md:col sm:col-6 xs:col-6">
                        <input type="text" onkeyup="this.value = mascaraANO(this.value)" class="form-control border-none w-100" id="ano" name="ano" placeholder="Ano" >                
                    </div>
                    <div class="p-2 md:col sm:col-6 xs:col-6">
                    <button type="submit" id="search" class="btn shadow-2 text-white bg-default w-100">Buscar</button>
                    </div>
                </div>                
            </form>
        </div>
        <div class="row gap-2 flex justify-content-center px-6 pm-2" id="content"></div>
    <script>
        $(document).ready(() => {
            const colorThief = new ColorThief();
            const images = $(".cars");
            for(let img of images) {
                if (img && img.complete) {
                    const cor = colorThief.getColor(img);
                    const corCSS = `rgb(${cor[0]}, ${cor[1]}, ${cor[2]})`;
                    img.style.backgroundColor = corCSS;
                } else {
                    img.addEventListener('load', function() {
                        const cor = colorThief.getColor(img);
                        const corCSS = `rgb(${cor[0]}, ${cor[1]}, ${cor[2]})`;
                        img.style.backgroundColor = corCSS;
                    });
                }
            }
        })
    </script>
    
</body>
</html>