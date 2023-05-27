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

    <div id="conteudo" class="container-fluid py-3">
        <div class="col-12 d-none" id="notFound">
            <div class="flex aling-items-center justify-content-center p-4">
                <div class="alert alert-warning" role="alert">
                    <h2 class="text-xl font-semibold">Carro não encontrado</h2>
                </div>
            </div>
        </div> 

        <div class="col-12" id="content">


            <!-- <body>
            <form action="car.php" method="post" enctype="multipart/form-data">
                <input type="file" id="fileInput" name="image" onchange="showPreview(event)" accept="image/*" multiple>
                <div id="preview" onclick="editImage()"></div>
                <br>
                <input type="submit" value="Salvar">
            </form>
            </body> -->


        </div>
    </div>

</body>
</html>