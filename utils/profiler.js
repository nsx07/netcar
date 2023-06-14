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

function mascaraTelefoneProfile(telefone) {
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
        PROFILEIMAGE = null;
        showUserPreview("/netcar/wwwroot/images/users/icone.png");
      },
      complete: () => load(false)
    })
  }
}

function setUserProfile() {
  $("#emailProfile")[0].value = user.email;
  $("#phoneProfile")[0].value = user.phone;
  $("#nameProfile")[0].innerHTML = `${user.name} ${user.surName}`;
  $("#phoneProfile").on("keyup", ev => $("#phoneProfile")[0].value = mascaraTelefoneProfile($("#phoneProfile")[0].value))
  checkFormProfile();
}

const catchErrorProfile = (response) => {
  if (typeof response !== "string") {
    return "Erro ao atualizar.";
  }

  for (let prop in formProfile.fields) {
      const len = response.split(" ");
      if (`'${prop}'` === len[len.length - 1]) {
          return formProfile.fields[prop].name + " já cadastrado.";
      }
  }
  return undefined;
}

async function getUserData() {
  load(true);
  await $.ajax({
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
    },
    complete: () => load(false)
  });
}

async function saveImage(ev) {
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
      } else if (response.message) {

        Swal.fire({
          position: 'bottom-start',
          icon: 'error',
          title: response.message,
          showConfirmButton: false,
        })

        PROFILEIMAGE = null;
        
      }
      
    },
    complete: () => load(false)
  })
}

async function saveUserData() {
  const form = $("#formProfile").serialize();

  load(true);
  $.ajax({
    type: "POST",
    url: '/netcar/utils/profiler.php',
    async: true,
    data: form,
    success: (response) => {
      try {
        response = JSON.parse(response);

        Toast.fire({
          icon: response.success ? 'success' : 'error',
          title: response.success? "Atualizado com sucesso!" : catchErrorProfile(response) ,
        });
        
        console.log(response);

      } catch (error) {

        console.log(response, catchErrorProfile(response));
        Toast.fire({
          icon: 'error',
          title: "Erro ao atualizar!",
        });

      }
      

    },
    complete: a => load(false)

  })
}

const formProfile = {
  valid: false,
  fields: {
    email : {value: '', name: "Email", type: 'regex', validator: /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/g, valid: false, message: "Email inválido"},
    phone : {value: '', name: "Telefone", type: 'minLength', validator: 11, valid: false, message: "Informe o telefone"},        
  }
}

const checkStateProfile = () => {
  let state = true;
  for (let item in formProfile.fields) {
      if (!formProfile.fields[item].valid) {
          state = false;
      }
  }

  formProfile.valid = state;
  return state;
}

const checkFormProfile = () => {
  const button = $("#saveProfile");
  const formGroup = $("#formProfile")[0]

  for (let prop in formProfile.fields) {
      field = formProfile.fields[prop]
      field.value = (formGroup[prop].value);
      const errorMessage = $(".feedback" + prop + 'profile')[0];

      switch (field.type) {
          case 'regex': 
              const regex = new RegExp(field.validator);
              field.valid = field.value.match(regex) && field.value.match(regex).length >= 1
              break;
          case 'minLength': 
              field.valid = formGroup[prop].value.toString().replace(/[\s.]?[\(\)]?[-]?/g, "").length === field.validator 
              break;
      }
  
      if (!field.valid ) {
          errorMessage.innerHTML = field.message;
      } else if (errorMessage && !formProfile.valid){
          errorMessage.innerHTML = "";
      }
  
      button.prop("disabled", !checkStateProfile());
  }
}

let user = null;

$(document).ready(function() {

  $("#profile").on('click', async ev => {
    await getUserData();
    setUserProfile();

  })

  $("#formProfile").on('keyup', ev => {checkFormProfile()});
  $("#formProfile").on('click', ev => {checkFormProfile()});

  $("#saveProfile").on("click", ev => {
    saveUserData();
  })

  $('#userInput').on("change", ev => {
    saveImage(ev);
  })

});