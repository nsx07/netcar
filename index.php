<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>netcar | Home </title>
    <link rel="icon" type="image/png" href="assets/logo-minify-purple.png">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

  <?php
    session_start();
    $url = dirname($_SERVER['SCRIPT_NAME']);        
    $url = substr($url,strrpos($url,"\\/")+1,strlen($url));  
    if (substr_count($url, '/') >= 1){                          
        $url = substr($url,strrpos($url,"\\/"),strlen($url));
        $url = strstr($url, '/',true);
    }
    $url = "Location: /" . $url . "/pages/homepage/homepage.php";	
    header($url);
?>
    
    <div class="bg-secondary vh-100" >

      <div class="d-flex d-flex-column justify-content-center align-items-center">
        <h2 class="text-center font-bold">NET CAR</h2>
        
        <div class="loader-liquid"></div>

        
        
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
  </body>
</html>