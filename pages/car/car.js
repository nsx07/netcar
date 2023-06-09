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

const fillCarousel = (cars) => {

  if (!cars) {
    return null; 
  } 

  if (cars.images.length < 1) {
    cars.images = ["default.png", "netcar-ban.png"];
  }

  let content = $("#content")[0]
  let assembledNav = "";
  let assembledNavFor = "";

  cars.images.forEach(images => {
    assembledNavFor += `<div class="flex align-items-center justify-content-center"><img style="width: 50vw" src="${WWWROOTPATH}images/cars/${images}" /></div>`;
    assembledNav += `<div> <img width="50vw" src="${WWWROOTPATH}images/cars/${images}"/> </div>`
  })

  let carBoilerPlate = `
  <div style="width: 100%" class="">
    <div class="slider-for mb-2">${assembledNavFor}</div>
    <div style="max-width: 55vw; margin: auto ">
        <div class="slider-nav">${assembledNav}</div>
    </div>
  </div>
  `;

  content.innerHTML += carBoilerPlate;

    $('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
    slidesToShow: 7,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    arrows: false,
    centerMode: true,
    focusOnSelect: true
  });
}

const parseURL = (url) => {
  return url.split("?")[1]?.split("&")[0]?.split("=")[1];;
}

let car = [];
let images = []

$(window).on("load", async ev => {
    var id = parseURL(location.toString());
    if (id) {
        car = await getCar(encodeURI("id=" + id))

        if (!car.length) {
            alert("Carro não encontrado!")
        } else [
          fillCarousel(car[0])
        ]
    } else {
        alert("id undefined")
    }
})

$(document).ready(function() {

});
