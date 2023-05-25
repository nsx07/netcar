<!DOCTYPE html>
<html>
<head>
  <title>Seleção de Imagem</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>

  <div class="container">
    <h1 class="mt-5 mb-3">Escolha a sua imagem para usar de perfil</h1>
    <div class="custom-file mb-3">
      <input type="file" class="custom-file-input" id="input-imagem" accept="image/*">
      <label class="custom-file-label" for="input-imagem">Escolha uma imagem</label>
    </div>
    <img id="imagem" src="#" alt="Imagem de perfil" class="img-thumbnail mb-3" style="max-width: 400px; display: block; margin: 0 auto; border: 2px solid black;">
 
    
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text"" class="form-control" id="nome" placeholder="Digite seu nome">
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="email" class="form-control" id="email" placeholder="Digite seu e-mail">
    </div>
    <div class="form-group">
      <label for="telefone">Telefone:</label>
      <input type="tel" class="form-control" id="telefone" placeholder="Digite seu telefone">
    </div>
    <button class="btn btn-primary">Salvar</button>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script>
    const inputImagem = document.getElementById('input-imagem');
    const imagem = document.getElementById('imagem');
    const nome = document.getElementById('nome');
    const email = document.getElementById('email');
    const telefone = document.getElementById('telefone');

    nome.value = "João Silva";
    email.value = "joao.silva@example.com";
    telefone.value = "(11) 99999-9999";

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

    
    const botaoSalvar = document.querySelector('button');
    botaoSalvar.addEventListener('click', function() {
      console.log(`Nome: ${nome.value}`);
      console.log(`E-mail: ${email.value}`);
      console.log(`Telefone: ${telefone.value}`);
    });
  </script>
</body>
</html>