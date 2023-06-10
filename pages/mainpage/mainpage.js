//#region API Methods

const mascaraANO = (ano) => {
    ano = ano.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    if (ano.length >= 5) {
        if(ano.length === 5){
            ano = ano.slice(0, 4);
        }
        else{
            for (let index = ano.length; index > 3; index--) {
                ano = ano.slice(0, index);                
            }
        }
    }

    const date = new Date();

    if (ano > date.getFullYear() || ano < 1950) {
        ano = date.getFullYear();
    }

    return ano;
}


const getCars = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "mainpage.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
                console.log(response);
                cars = JSON.parse(response);
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

const getBrands = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "../../crud/brand/brand.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
                brands = JSON.parse(response);
                res(JSON.parse(response));
                adicionarItensAoSelectBrands(brands);
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

const getModels = (id) => {
    const promise = new Promise(async (res,rej) => {
        await $.ajax({
            method: "GET",
            url: "../../crud/model/model.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
                models = JSON.parse(response);
                res(JSON.parse(response))
                adicionarItensAoSelectModels(models);
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

//#endregion

//#region Listing

const applyImages = (car) => {
    let imagesElement = "";

    if (car.images && car.images < 1 ) {
        car.images = ["default.png", "netcar-ban.png"];
    }

    const ids = [], images = [];

    car.images.forEach((image, index) => {
        const id = Math.pow(index, Math.random() + 1).toString() + image;
        const imagePath = `${WWWROOTPATH}images/cars/${image}`;
        imagesElement += `
            <div class='carousel-item ${index === 0 ? 'active' : ''}'>
                <img id='${id}' src='${imagePath}' class='card-img-top cars'>
            </div>
        `;
    });

    return imagesElement
}

const carBoilerPlate = (car) => {
    if (!car) {
        return null;
    }

    return `
    <div class='card col-lg-3 col-md-6 col-sm-12 p-0 border-none min-w-15rem'>
        <div id='${car.id}' class='carousel slide'>
            <div class='carousel-inner'>
                ${applyImages(car)}
            </div>
            <button class='carousel-control-prev' type='button' data-bs-target='#${car.id}' data-bs-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Previous</span>
            </button>
            <button class='carousel-control-next' type='button' data-bs-target='#${car.id}' data-bs-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Next</span>
            </button>
        </div>
        
        <div class='card-body'>
            <div class='flex justify-content-between align-items-center'>
                <a href='../car/?id=${car.id}'> <h5 class='card-title'>${car.modelName}</h5> </a>
                <div class='border-round-md px-2 py-1 text-white shadow-2'>
                    <span class='text-gray-800'>R$ ${car.price}</span>
                </div>
            </div>
            <p class='card-text'> ${car.brandName} - ${car.year} </p>
            <form id='purcharse_car' onsubmit='return false'>
                <div class='flex gap-2 justify-content-center align-items-center'>
                    <a type='submit' href='../car/?id=${car.id}' class='btn w-100 text-white shadow-3 bg-default'>Detalhes <i class='fa-solid fa-cart-shopping'></i></a>
                </div>
            </form>
        </div>
    </div> 
    `;
            // <a type='submit' class='btn w-100 text-white shadow-2 btn-success'>Salvar <i class='fa-solid fa-bookmark'></i></a>
}

const fillTable = (cars) => {
    const line = $("#content")[0];

    if (!cars) {
        line.innerHTML = null;
        return;
    }

    if (cars.length === 0) {
        line.innerHTML = `
        <div class='p-4 flex justify-content-center align-items-center'>
            <h2 class='font-semibold'>Nenhum carro encontrado</h2>
        </div>
        `;
        return;
    }

    for (let car of cars) {
        line.innerHTML += carBoilerPlate(car);
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

//#endregion

//#region Variables

let cars = [];
let items = [];
let brands = [];
let models = [];
let callback = null;

//#endregion
function adicionarItensAoSelectBrands(brands) {
    const selectElement = document.getElementById('brands');   
    // Adiciona os itens ao <select>
    brands.forEach((brand) => {     
      const optionElement = document.createElement('option');        
      optionElement.value = brand.name;
      optionElement.textContent = brand.name;
      selectElement.appendChild(optionElement);
    });
  }

  function adicionarItensAoSelectModels(models) {
    const selectElement = document.getElementById('models');
    // Adiciona os itens ao <select>
    models.forEach((models) => {     
      const optionElement = document.createElement('option');        
      optionElement.value = models.name;
      optionElement.textContent = models.name;
      selectElement.appendChild(optionElement);
    });
  }

const Toast = Swal.mixin({
    toast: true,
    timer: 3000,
    position: 'bottom-end',
    showConfirmButton: false,
    timerProgressBar: true,
})

$(window).on("load", async ev => {
    getCars(encodeURI("method=GET"))
        .then(resp => {
            console.log(resp);
            fillTable(resp);
        })
        .catch(resp => console.warn(resp))    
})

$(window).on("load", async ev => {        
    getBrands(encodeURI("method=GET"))
        .then(resp => {
            console.log(resp);
        })
        .catch(resp => console.warn(resp)) 
})

$(window).on("load", async ev => {        
    getModels(encodeURI("method=GET"))
        .then(resp => {
            console.log(resp);
        })
        .catch(resp => console.warn(resp)) 
})



function filtrar(cars){
    const selectElementBrand = document.getElementById('brands');
    const selectElementModel = document.getElementById('models');
    let brand = selectElementBrand.value;
    let model = selectElementModel.value;
    let ano = document.getElementById('ano').value;

    if(brand != null && brand != "" && brand != "semFiltroBrands"){
        cars = cars.filter((obj) => obj.brand === brand);
    }     
    if(ano != null && ano != ""){
        cars = cars.filter((obj) => obj.year === ano);
    }  
    if(model != null && model != "" && model != "semFiltroModels"){
        cars = cars.filter((obj) => obj.modelName === model);
    }
    fillTable(null);
    fillTable(cars);
    console.log(cars);   
    
}

$(document).ready(function() {
    $('#search').click(function(event) {
      const promise = new Promise(async (res,rej) => { 
      event.preventDefault();
      var formData = $('#filter').serialize(); // Obtém os dados do formulário
      await
      $.ajax({
        type: 'GET',
        url: 'mainpage.php',
        data: formData,
        async: true,
        success: (response) => {
            cars = JSON.parse(response);
            filtrar(cars);                                   
        },
        error : (response) => {
            rej(JSON.parse(response))
        }
      })
    })
  })
})


