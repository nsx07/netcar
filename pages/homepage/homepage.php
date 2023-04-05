<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="homepage.css">    
    <script src="homepage.js"></script>
</head>
<body>
    
    <?php require '../../components/nav.html';?>


    <div class="container-fluid py-3">

        <div class="row gap-2 flex justify-content-center px-6 pm-2">

            <div class="col-12">
                <form id="filter" action="" autocomplete="off" onsubmit="return false"  method="post" target="_self">                
                    <div class="flex justify-content-center align-items-center column-gap-2 rounded gap-2">
                        <input type="text" class="form-control shadow w-50" id="name" name="name" data-noresults-text="Nothing to see here." autocomplete="off" placeholder="Pesquise por modelo ou marca" required>                                            
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


            <?php 
            $jsonString = file_get_contents('../../assets/cars.json');
            $jsonData = json_decode($jsonString, true);

            foreach ($jsonData["cars"] as $car ) { 
                echo "
                <div class='card col-lg-3 col-md-6 col-sm-12 p-0 border-none' style='width: 18rem;'>
                    <img src='../../assets/{$car['assetsPath']}' class='card-img-top cars'>
                    <div class='card-body'>
                        <a href='#'> <h5 class='card-title'>{$car['model']}</h5> </a>
                        <p class='card-text'> {$car['brand']} - {$car['year']} </p>
                        <form id='purcharse_car' onsubmit='return false'>
                        <div class='flex gap-2 justify-content-center'>
                            <button type='submit' href='#' class='btn w-100 text-white btn-success'>Salvar <i class='fa-solid fa-bookmark'></i></button>
                            <button type='submit' href='#' class='btn w-100 text-white bg-default'>Comprar <i class='fa-solid fa-cart-shopping'></i></button>
                        </div>
                        </form>
                    </div>
                </div> ";
                }
            ?>
        </div>

    </div>
    
</body>
</html>