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
                <div class="flex justify-content-center align-items-center column-gap-1 rounded">
                        <select class="form-select" id="models" style="width: 400px" name="models">
                            <option value="semFiltroModels">Sem filtro de modelo!</option>
                        </select>                    
                        <div class="input-group">
                            <span class="input-group-text border-none bg-white color-default" id="basic-addon1"> <i class="fa-solid fa-search"></i> </span>
                            <input type="text" class="form-control border-none w-95" id="name" name="name" data-noresults-text="Nothing to see here." autocomplete="off" placeholder="Pesquise..." aria-describedby="basic-addon1">          
                        </div>                    
                        <select class="form-select" id="brands" style="width: 400px" name="brands">
                            <option value="semFiltroBrands">Sem filtro de marca!</option>
                        </select>
                    <input type="text" onkeyup="this.value = mascaraANO(this.value)" class="form-control border-none" style="width: 100px" id="ano" name="ano" data-noresults-text="Nothing to see here." autocomplete="off" placeholder="Ano" aria-describedby="basic-addon1" >                
                    <button type="submit" id="search" class="btn shadow text-white bg-default" style="cursor: pointer">Buscar</button>
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