function showPreview(event) {
  const preview = $('#preview')[0];

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

function editImage() {
  $('#fileInput').click();
}

let PROFILEIMAGE = null;

function deleteImage() {
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
        showPreview("/netcar/wwwroot/images/users/icone.png");
        load(false);
      }
    })
  }
}

function load(state) {
 if (state) {
  $('#loader').fadeIn('slow');
 } else {
  $('#loader').fadeOut('slow');
 }
}


$(document).ready(function() {
  load(true);
  $.ajax({
    type: "GET",
    url: '/netcar/utils/profiler.php',
    async: true,
    success: (response) => {
        if (response) {
          response = JSON.parse(response);
          let img = null;
          
          if (Array.isArray(response.image) && response.image.length) {
            img = response.image[0];
            PROFILEIMAGE = `/netcar/wwwroot/images/users/${img}`;
          } else {
            img = "icone.png"
          }
                      
          showPreview(`/netcar/wwwroot/images/users/${img}`);
          load(false);
          
        }
    }
  });


  $('#fileInput').on("change", ev => {
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
          showPreview(PROFILEIMAGE);
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