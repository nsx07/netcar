const getCar = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "car.php",
            data: id,
            async: true,
            success : (response) => {
                console.log(response);
                car = JSON.parse(response);
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

function showPreview(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
      var preview = $('#preview')[0];
      preview.style.backgroundImage = 'url(' + reader.result + ')';
    };

    reader.readAsDataURL(input.files[0]);
}

function editImage() {
    $("#fileInput").click();
}

let car = [];
let images = []

const parseURL = (url) => {
    return url.split("?")[1]?.split("&")[0]?.split("=")[1];;
}

$(window).on("load", async ev => {
    var id = parseURL(location.toString());
    if (id) {
        car = await getCar(encodeURI("id=" + id))

        if (!car.length) {
            alert("Carro não encontrado!")
        }
    } else {
        alert("id undefined")
    }

    console.log(WWWROOTPATH);
})

$(document).ready(function() {
    $('#fileInput').change(function() {
      var formData = new FormData();

      $.each($('#fileInput')[0].files, function(i, file) {
        formData.append('images[]', file);
      });

      $.ajax({
        url: 'car.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          alert(response);
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
