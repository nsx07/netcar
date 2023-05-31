function showPreview(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
      var preview = $('#preview');
      preview.style.backgroundImage = 'url(' + reader.result + ')';
    };

    reader.readAsDataURL(input.files[0]);
  }

  function editImage() {
    var fileInput = $('#fileInput');
    fileInput.click();
  }

  let PROFILEIMAGE = null;

  
  $(document).ready(function() {
    
    $.ajax({
      type: "GET",
      url: '/netcar/utils/profiler.php',
      async: true,
      success: (response) => {
        console.log(response);
          if (response) {
              response = JSON.parse(response);
              let img = Array.isArray(response) && response.length ? response[0] : "icone.png";
              
              console.log(`url('/netcar/wwwroot/images/users/${img}')`);
          //     var preview = $('#preview');
          //     preview.style = {};
          //     preview.style.backgroundImage = `url('/netcar/wwwroot/images/users/${img}')`              
          }
      }
    });

  });