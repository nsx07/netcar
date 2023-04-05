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
    $url = "Location: /" . $url . "/pages/home/";	
    header($url);
  ?>
    
  </body>
</html>