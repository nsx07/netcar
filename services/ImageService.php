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
    $targetDir = get_defined_constants()["wwwroot"] . 'images/' . $target . "/";

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $imageFileType = strtolower(pathinfo($_FILES['images']['name'][$key], PATHINFO_EXTENSION));

        $imageName = $baseName . "-" . uniqid() . '.' . $imageFileType;
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($tmp_name, $targetFile)) {
            echo "A imagem $imageName foi enviada com sucesso.";
        } else {
            echo "Ocorreu um erro ao enviar a imagem $imageName.";
        }
    }
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

function deleteImages($baseName, $target) {
    $images = getImages($baseName, $target);

    foreach ($images as $image => $name) {
        $imagePath = get_defined_constants()["wwwroot"] . 'images/' . $target . "/" . $name;
        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                echo "A imagem foi excluída com sucesso.";
            } else {
                echo "Ocorreu um erro ao excluir a imagem " . $name;
            }
        } else {
            echo "O arquivo não existe.";
        }
    }

}
