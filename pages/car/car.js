const getCar = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        load(true)
        $.ajax({
            method: "GET",
            url: "car.php",
            data: id,
            async: true,
            success : (response) => {
              console.log( response);
              if (response != "null") {
                console.log(typeof response);
                car = JSON.parse(response);
              }
              res(car)
            },
            error : (response) => {
                rej(JSON.parse(response))
            },
            complete: () => load(false)
        })
    })

    return promise
}

const fillCarousel = (cars) => {

  if (!cars) {
    return null; 
  } 

  if (cars.images.length < 1) {
    cars.images = ["default.png"];
  }

  let content = $("#carousel")[0]
  let assembledNav = "";
  let assembledNavFor = "";

  cars.images.forEach(images => {
    assembledNavFor += `<div class="flex align-items-center justify-content-center"><img class='img-carousel' src="${WWWROOTPATH}images/cars/${images}" /></div>`;
  })

  let carBoilerPlate = `
  <div style="width: 100vw">
    <div class="slider-for mb-4">${assembledNavFor}</div>
  </div>
  `;

  content.innerHTML += carBoilerPlate;

  $('.slider-for').slick({
    dots: true,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear'
  });
}

const parseURL = (url) => {
  return url.split("?")[1]?.split("&")[0]?.split("=")[1];;
}

const colors = {    
  Azul: "#0000FF",
  Vermelho: "#FF0000",
  Verde: "#00FF00",
  Amarelo: "#FFFF00",
  Laranja: "#FFA500",
  Roxo: "#800080",
  Rosa: "#FFC0CB",
  Preto: "#000000",
  Branco: "#FFFFFF",
  Cinza: "#808080"
};

const getColor = (keyValue) => {
  for (let [key, value] of Object.entries(colors)) {
    if (key === keyValue) {
      return value;
    } else if (value === keyValue) {
      return key;
    }
  }
}

function setInfo() {
  $("#content")[0].classList.remove("d-none")
  
  fillCarousel(car)
  $("#carName")[0].innerHTML = `${car.name} ${car.year}`;
  $("#carPrice")[0].innerHTML += `R$ ${car.price}`;
  $("#carDescription")[0].innerHTML += `${car.description}`;
  $("#carBrand")[0].innerHTML = `${car.brand}`;
  $("#carYear")[0].innerHTML = `${car.year}`;
  $("#carKM")[0].innerHTML = `${car.kilometers}`;
  $("#carColor")[0].innerHTML = `${getColor(car.color)}`

  setItens();
}

function setItens() {
  const itenContainer = $("#carItens")[0];

  if (car.itens.length < 1) {
    itenContainer.innerHTML = `<div class="col-12 text-center">Este carro não possui nenhum item cadastrado ainda</div>`;
    return;
  }

  for (let i = 0; i < car.itens.length; i++) {
    itenContainer.innerHTML += `
    <div class="col-2 bg-gray-300 border-round-2xl p-2 w-max">
      <span class='text-black text-center font-medium'>${car.itens[i]}</span>
    </div>
    `;
  }

}

let car = [];
let images = []

$(window).on("load", async ev => {
    var id = parseURL(location.toString());
    if (id) {
        car = await getCar(encodeURI("id=" + id))
        console.log(car);

        if (car && !Array.isArray(car)) {
          document.title = `${car.name} ${car.year} | netcar`;
          setInfo();
        } else {
          $("#notFound")[0].classList.remove("d-none")
        }
    } else {
      $("#notFound")[0].classList.remove("d-none")
    }
})

$(document).ready(function() {

});
