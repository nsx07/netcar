//#region API Methods

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

//#endregion

//#region Listing

const carBoilerPlate = (car) => {
    if (!car) {
        return null;
    }

    return `
    <div class='card col-lg-3 col-md-6 col-sm-12 p-0 border-none'>
        <div id='${car.id}' class='carousel slide'>
            <div class='carousel-inner'>
                <div class='carousel-item'>
                    <img src='../../assets/default.png' class='card-img-top cars'>
                </div>
                <div class='carousel-item active'>
                    <img src='../../assets/netcar-ban.png' class='card-img-top cars'>
                </div>
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
            <a href='#'> <h5 class='card-title'>${car.modelName}</h5> </a>
            <p class='card-text'> ${car.brandName} - ${car.year} </p>
            <form id='purcharse_car' onsubmit='return false'>
            <div class='flex gap-2 justify-content-center'>
                <button type='submit' href='#' class='btn w-100 text-white btn-success'>Salvar <i class='fa-solid fa-bookmark'></i></button>
                <button type='submit' href='#' class='btn w-100 text-white bg-default'>Comprar <i class='fa-solid fa-cart-shopping'></i></button>
            </div>
            </form>
        </div>
    </div> 
    `;
}

const fillTable = (cars) => {
    const line = $("#content")[0];

    if (!cars) {
        line.innerHTML = null;
        return;
    }

    if (cars.length === 0) {
        line.innerHTML = `
        <div class='p-4 flex justify-content-center aling-items-center'>
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

$(document).ready(() => {
    $("#keyword").on("keyup", ({target}) => {
        getCars(encodeURI(`keyword=${target.value}&method=GET`))
        .then(resp => {
            fillTable(null);
            fillTable(resp);
        })
    })

    const button = $("#save");
    
    // $("#form").on("keyup", ev => checkForm(button))
    // $("#form").on("click", ev => checkForm(button))

    button.click(event => {
        $("#default")[0].classList.add("d-none")
        $("#loading")[0].classList.remove("d-none");
        button.prop("disabled", false);

        callback();
                        
        $("#default")[0].classList.remove("d-none")
        $("#loading")[0].classList.add("d-none");
    })
})