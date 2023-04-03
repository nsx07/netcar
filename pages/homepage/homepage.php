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
            $date = date("d/m/y");
            for ($i=0; $i < 30; $i++) { 
                echo "<div class='card col-lg-3 col-md-6 col-sm-12 p-0' style='width: 18rem;'>";
                echo "    <img src='../../assets/cars/toyotagr.jpg' class='card-img-top w-100' alt='...'>";
                echo "    <div class='card-body'>";
                echo "        <a href='#'> <h5 class='card-title'>Card title</h5> </a>";
                echo $date;
                echo "        <p class='card-text'>Some quick example text to build on the card title and make up the bulk of the card's content.</p>";
                echo "        <form id='purcharse_car' onsubmit='return false'>";
                echo "        <div class='flex gap-2 justify-content-center'>";
                echo "            <button type='submit' href='#' class='btn w-100 text-white btn-success'>Salvar <i class='fa-solid fa-bookmark'></i></button>";
                echo "            <button type='submit' href='#' data-bs-toggle='modal' data-bs-target='#exampleModal' class='btn w-100 text-white bg-default'>Comprar <i class='fa-solid fa-cart-shopping'></i></button>";
                echo "        </div>";
                echo "        </form>";
                echo "    </div>";
                echo "</div>    ";
                }
            ?>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

        </div>

    </div>
    
</body>
</html>