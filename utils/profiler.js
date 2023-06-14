function showUserPreview(event) {
  const preview = $('#userPreview')[0];

  if (!preview) return;

  try {
    if (typeof event !== 'string') {
    
      var input = event.target;
      var reader = new FileReader();
  
      reader.onload = function() {
        preview.style.backgroundImage = 'url(' + reader.result + ')';
      };
  
      reader.readAsDataURL(input.files[0]);
    } else {
      fetch(event).then(response => response.blob()).then(blob => {
        const image = URL.createObjectURL(blob);
        preview.style.backgroundImage = 'url(' + image + ')';
      })
    }
  } catch (error) {
    // console.log("erro ao carregar imagem");
  }

}

function editUserImage() {
  $('#userInput').click();
}

function mascaraTelefone(telefone) {
  telefone = telefone.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
  telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2'); // Adiciona parênteses em volta dos primeiros 2 dígitos
  telefone = telefone.replace(/(\d)(\d{4})$/, '$1-$2'); // Adiciona hífen entre o quinto e sexto dígitos
  return telefone;
}

let PROFILEIMAGE = null;

function deleteUserImage() {
  if (PROFILEIMAGE) {
    load(true);
    $.ajax({
      method: "DELETE",
      url: "/netcar/utils/profiler.php",
      async: true,
      processData: false,
      contentType: false,
      success: (r) => {
        // console.log(r);
        PROFILEIMAGE = null;
        showUserPreview("/netcar/wwwroot/images/users/icone.png");
        load(false);
      }
    })
  }
}

function setUser() {
  console.log($("#emailProfile")[0]);
  $("#emailProfile")[0].value = user.email;
  console.log($("#phoneProfile")[0]);
  $("#phoneProfile")[0].value = user.phone;
  $("#phoneProfile").on("keyup", ev => $("#phoneProfile")[0].value = mascaraTelefone($("#phoneProfile")[0].value))
}

let user = null;

$(document).ready(function() {

  $("#profile").on('click', ev => {
    setUser();
  })


  load(true);
  $.ajax({
    type: "GET",
    url: '/netcar/utils/profiler.php',
    async: true,
    success: (response) => {
      console.log(response);
      if (response) {
          response = JSON.parse(response);
          let img = null;
          
          if (Array.isArray(response.image) && response.image.length) {
            img = response.image[0];
            PROFILEIMAGE = `/netcar/wwwroot/images/users/${img}`;
          } else {
            img = "icone.png"
          }
                      
          showUserPreview(`/netcar/wwwroot/images/users/${img}`);
          load(false);

          if (response.user) {
            user = response.user;
          }
          
        }
    }
  });


  $('#userInput').on("change", ev => {
    const formData = new FormData();
    formData.append('image', ev.target.files[0]);
    load(true);
    $.ajax({
      type: "POST",
      url: '/netcar/utils/profiler.php',
      async: true,
      processData: false,
      contentType: false,
      data: formData,
      success: (response) => {
        console.log(response);
        response = JSON.parse(response);
        console.log(response);
        if (response.status === 1) {
          PROFILEIMAGE = response.path;
          PROFILEIMAGE = "/netcar" + new String(PROFILEIMAGE).slice(2);
          showUserPreview(PROFILEIMAGE);
        } else {

          Swal.fire({
            position: 'bottom-start',
            icon: 'error',
            title: response.message,
            showConfirmButton: false,
          })
          PROFILEIMAGE = null;
          
        }
        load(false);
      }
    })
    
  })

});