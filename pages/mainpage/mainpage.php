<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MainPage | netcar</title>
    <link rel="icon" type="image" href="../../assets/logo-minify-purple.png">
    <link rel="stylesheet" href="mainpage.css">
    <source src="login.js" type="text/js">

    <style>
    body {
      background-color: grey;
    }

    .col-md-8 {
      background-color: #444;
    }

    .d-flex {
      background-color: #444;
    }

    .btn-primary {
      background-color: #444;
    }

    .btn-secondary {
      background-color: #444;
    }

    .form-group {
      background-color: #444;
    }

    .form-control {
      background-color: #444;
    }

    .container {
      background-color: #444;
    }
    .navbar {
    background-color: #444;
   
    }
    .hop{
      background-color: #fff;
    }

    .navbar-brand {
      background-color: #fff;
    }

    .logomercadopago {
      float: center;
      background-color: #444;
    }

    .LOGO {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
     
    }

    .logo p {
      align-items: center;
     
    }

    .image-container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background-color: #444;
    }

    .image-container img {
      margin-right: 10px;
      background-color: #444;
    }

  </style>

</head>
<body>

    <?php require '../../components/nav.html';?>

    <div class="container mt-3">
    <div class="row"  style="padding-bottom:10px">
      <div class="col-md-6">
        <div class="form-group">
          <br><br>
          <input type="text"  class="form-control"  style="background-color: white;" id="busca" placeholder="Digite sua busca..." >
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group d-flex align-items-end justify-content-end h-100">
          <button type="button" class="btn btn-primary bg-white mr-2" style="color: purple">Buscar</button>
          <button type="button" class="btn btn-secondary bg-white" style="color: purple">Filtrar</button>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="container" style="padding-top:10px">
    <div class="row"  style="padding-bottom:10px">
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/hb20.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">HB20</h5>
            <p class="card-text">HB20 seminovo </p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">NetCar</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/camaro.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">Camaro</h5>
            <p class="card-text">camaro seminovo</p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">NetCar</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/subaro.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Subaro seminovo </p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">NetCar</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/mille.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">UNO mille</h5>
            <p class="card-text">o mais rápido do mundo</p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">NetCar</small>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container" style="padding-bottom:10px">
    <div class="row" >
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/ferrari.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">ferrari</h5>
            <p class="card-text">red</p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">NetCar</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/camaro.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">Camaro</h5>
            <p class="card-text">camaro seminovo</p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">NetCar</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/subaro.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">Subaro seminovo </p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">Card footer</small>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <img src="../../assets/Carros/mille.png" class="card-img-top" alt="..." height="150px" width="100px">
          <div class="card-body">
            <h5 class="card-title">UNO mille</h5>
            <p class="card-text">o mais rápido do mundo</p>
            <a href="#" class="btn btn-primary">SALVAR</a>
            <a href="#" class="btn btn-secondary">COMPRAR</a>
          </div>
          <div class="card-footer">
            <small class="text-muted">Card footer</small>
          </div>
        </div>
      </div>
    </div>
  </div>



    
</body>
</html>