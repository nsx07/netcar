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
            <form id="filter" onsubmit="return false"  method="POST">                
                <div class="flex justify-content-center align-items-center column-gap-1 rounded">
                    <div class="input-group">
                        <span class="input-group-text border-none bg-white color-default" id="basic-addon1"> <i class="fa-solid fa-search"></i> </span>
                        <input type="text" class="form-control border-none w-75" id="name" name="name" data-noresults-text="Nothing to see here." autocomplete="off" placeholder="Pesquise..." aria-describedby="basic-addon1" required> 
                    </div>

                    <div class="dropdown">
                        <a class="btn shadow text-white bg-default" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-filter opacity-2 "></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Ano</a></li>
                            <li><a class="dropdown-item" href="#">Marca</a></li>
                            <li><a class="dropdown-item" href="#">Modelo</a></li>
                        </ul>
                    </div>
                    <button type="submit" id="search" class="btn shadow text-white bg-default">Buscar</button>
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