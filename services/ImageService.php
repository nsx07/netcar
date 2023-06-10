<?php 

define("wwwroot", "../../wwwroot/");

function saveImage($fileName, $target, $image, $root = "../../") {
    $targetDir = $root . 'wwwroot/images/' . $target . "/";
    $targetFile = $targetDir . basename($image['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $uploadOk = 1;
    $response = array();

    $imageName = $fileName . "-" . uniqid() . '.' . $imageFileType;
    $targetFile = $targetDir . $imageName;

    if (isset($_POST["submit"])) {
        $check = getimagesize($image['tmp_name']);
        if ($check === false) {
            $response['message'] = "O arquivo não é uma imagem.";
            $uploadOk = 0;
        }
    }

    if (file_exists($targetFile)) {
        $response['message'] = "Já existe um arquivo com esse nome.";
        $uploadOk = 0;
    }

    $maxFileSize = 2 * 1024 * 1024;
    if ($image['size'] > $maxFileSize) {
        $response['message'] = "O tamanho do arquivo excede o limite máximo.";
        $uploadOk = 0;
    }

    $allowedFormats = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedFormats)) {
        $response['message'] = "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        $uploadOk = 0;
    }

    if ($uploadOk === 0) {
        $response['final_message'] = "O arquivo não pôde ser enviado.";
    } else {
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $response['final_message'] = "O arquivo foi enviado com sucesso.";
            $response["path"] = $targetFile;
        } else {
            $response['final_message'] = "Ocorreu um erro ao enviar o arquivo.";
        }
    }
    
    $response["status"] = $uploadOk;
    return $response;
}

function saveImages($baseName, $target, $images, $root = "../../") {
    $responses = array();
    $targetDir = $root . 'wwwroot/images/' . $target . "/";

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $imageFileType = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));

        $imageName = $baseName . "-" . uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($tmp_name, $targetFile)) {
            $responses[$key] = "A imagem $imageName foi enviada com sucesso.";
        } else {
            $responses[$key] = "Ocorreu um erro ao enviar a imagem $imageName.";
        }
    }

    return $responses;
}

function getImagesByPath($baseName, $target, $path) {
    $files = scandir($path);
    $files = array_filter($files, function($file) {
        return !in_array($file, array('.', '..'));
    });

    $filesMatch = array();
    foreach ($files as $file) {
        if (str_contains($file, $baseName . "-")) {
            array_push($filesMatch, $file);
        }
    }

    return $filesMatch;
}

function getImages($baseName, $target, $root = "../../") {
    $dirPath =  $root . 'wwwroot/images/' . $target . "/";
    $files = scandir($dirPath);
    $files = array_filter($files, function($file) {
        return !in_array($file, array('.', '..'));
    });

    $filesMatch = array();
    foreach ($files as $file) {
        if (str_contains($file, $baseName . "-")) {
            array_push($filesMatch, $file);
        }
    }

    return $filesMatch;
}

function deleteImage($imgPath) {
    $response = array();

    if (file_exists($imgPath)) {
        if (unlink($imgPath)) {
            $response["message"] = "A imagem foi excluída com sucesso.";
        } else {
            $response["message"] = "Ocorreu um erro ao excluir a imagem " . $imgPath;
        }
    } else {
        $response["message"] = "O arquivo não existe.";
    }

    return $response;
}

function deleteImages($baseName, $target, $root = "../../") {
    $response = array();
    $images = getImages($baseName, $target, $root);

    foreach ($images as $image => $name) {
        $imagePath = $root . 'wwwroot/images/' . $target . "/" . $name;
        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                $response[$image] = "A imagem foi excluída com sucesso.";
            } else {
                $response[$image] = "Ocorreu um erro ao excluir a imagem " . $name;
            }
        } else {
            $response[$image] = "O arquivo não existe.";
        }
    }
    return $response;
}
