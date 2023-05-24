<?php require '../../components/nav.php';?>

<body>
    <h1>Selecione uma imagem:</h1>
    <input type="file" id="input-imagem" accept="image/*">
    <br><br>
    <img id="imagem" src="#" alt="Imagem de perfil">
    
    <script>
      const inputImagem = document.getElementById('input-imagem');
      const imagem = document.getElementById('imagem');
      
      inputImagem.addEventListener('change', function() {
        const file = inputImagem.files[0];
        const reader = new FileReader();
        
        reader.addEventListener('load', function() {
          imagem.src = reader.result;
        }, false);
        
        if (file) {
          reader.readAsDataURL(file);
        }
      });
    </script>
  </body>