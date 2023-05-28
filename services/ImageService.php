<?php 

define("wwwroot", "../../wwwroot/");


function saveImage($fileName, $target, $image) {
    $targetDir = get_defined_constants()["wwwroot"] . 'images/' . $target . "/";
    $targetFile = $targetDir . basename($image['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $imageName = $fileName . '.' . $imageFileType;
    $targetFile = $targetDir . $imageName;

    if (isset($_POST["submit"])) {
        $check = getimagesize($image['tmp_name']);
        if ($check === false) {
            echo "O arquivo não é uma imagem.";
            $uploadOk = 0;
        }
    }

    if (file_exists($targetFile)) {
        echo "Já existe um arquivo com esse nome.";
        $uploadOk = 0;
    }

    $maxFileSize = 2 * 1024 * 1024;
    if ($image['size'] > $maxFileSize) {
        echo "O tamanho do arquivo excede o limite máximo.";
        $uploadOk = 0;
    }

    $allowedFormats = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        $uploadOk = 0;
    }

    if ($uploadOk === 0) {
        echo "O arquivo não pôde ser enviado.";
    } else {
        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            echo "O arquivo foi enviado com sucesso.";
        } else {
            echo "Ocorreu um erro ao enviar o arquivo.";
        }
    }
}

function saveImages($baseName, $target, $images) {
    $responses = array();
    $targetDir = get_defined_constants()["wwwroot"] . 'images/' . $target . "/";

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

function getImages($baseName, $target) {
    $dirPath =  get_defined_constants()["wwwroot"] . 'images/' . $target . "/";
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

    echo $response["message"];

    return $response;
}

function deleteImages($baseName, $target) {
    $response = array();
    $images = getImages($baseName, $target);

    foreach ($images as $image => $name) {
        $imagePath = get_defined_constants()["wwwroot"] . 'images/' . $target . "/" . $name;
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
