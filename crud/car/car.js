//#region API Methods

const getCars = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "car.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
                console.log(response)
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

const deleteCar = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "DELETE",
            url: "car.php/" + id,
            data: id,
            async: true,
            success : (response) => {
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

const newEntity = () => {
    resetForm();
    fillCarousel(null);
    setState("Cadastrar Carro", () => {
        console.log($("#form").serialize());
        const data = prepareImages();
        data.append("data", $("#form").serialize())

        $.ajax({
            type: "POST",
            url: "car.php",
            async:true,
            processData: false,
            contentType: false,
            data: data,
            success: function (response) {
                console.log(response);
                try {
                    response = JSON.parse(response);

                    if (response.success) {
                          
                        Toast.fire({
                            icon: 'success',
                            title: 'Cadastrado com sucesso!'
                        })

                        getCars(encodeURI("method=GET"))
                        .then(resp => {
                            fillTable(null);
                            fillTable(resp)

                            $("#close").click();

                        })
                        .catch(resp => console.warn(resp))

                    } else {

                        Toast.fire({
                            icon: 'error',
                            title: 'Erro ao cadastrar!',
                            text: `${catchError(response).name} já cadastrado.`
                        })

                    }    
                } catch (error) {
                    console.error("Error catched" + error);
                }
            }
        })

    })
}

const edit = (id) => {
    const car = cars.find(car => car.id == id);
    fillForm(car);
    fillCarousel(car);
    setState("Editar Carro", () => {
        console.log(car, $("#form").serialize() ,cars);

        const data = prepareImages();
        console.log(data.get("images[]"));
        data.append("data", $("#form").serialize())
        $.ajax({
            type: "POST",
            url: "car.php",
            async:true,
            processData: false,
            contentType: false,
            data: data,
            success: function (response) {
                console.log(response);
                try {
                    response = JSON.parse(response);

                    if (response.success) {
                          
                        Toast.fire({
                            icon: 'success',
                            title: 'Atualizado com sucesso!'
                        })

                        getCars()
                        .then(resp => {
                            fillTable(null);
                            fillTable(resp)

                            $("#close").click();

                        })
                        .catch(resp => console.warn(resp))

                    } else {

                        Toast.fire({
                            icon: 'error',
                            title: 'Erro ao atualizar!',
                        })

                    }    
                } catch (error) {
                    console.error("Error catched" + error);
                }
            }
        })  
    })
}

const deleteImage = () => {
    const activeImage = $(".active img")[0]
    
    console.log(activeImage.src);

    var parsed = activeImage.src.split("netcar")[1];
    var parsedTo = "../.." + parsed

    console.log(parsed);

    $.ajax({
        type: "PUT",
        url: "car.php",
        async:true,
        processData: false,
        contentType: false,
        data: encodeURI("deleteImgPath=" + parsedTo),
        success: function (response) {
            console.log(response);
            location.reload();
        }
    })  
}

const delete_ = (id) => {
    Swal.fire({
        title: 'Deseja excluir?',
        showDenyButton: true,
        confirmButtonText: 'Confirmar',
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
            deleteCar(encodeURI(`id=${id}`))
            .then(response => {
                
                if (response.success) {
                    getCars()
                    .then(resp => {
                        fillTable(null);
                        fillTable(resp)

                        $("#close").click();

                    })
                    .catch(resp => console.warn(resp))
                    Toast.fire({
                        icon: 'success',
                        title: 'Removido com sucesso!'
                    })
                } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Erro ao excluri!'
                    })
                }
            })
            .catch(response => {
                
            })
        }
      })
}

const prepareImages = () => {
    var formData = new FormData();
    console.log($('#images')[0]);
    $.each($('#images')[0].files, function(i, file) {
      formData.append('images[]', file);
    });

    return formData;
}

//#endregion

//#region Listing

function showPreview(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
        var preview = $('#' + currentImg);
        preview.prop("src", reader.result)
    };

    reader.readAsDataURL(input.files[0]);
}

let currentImg = null; 

function editImage(imgId) {
    currentImg = imgId;
    $("#images").click();
}

const carBoilerPlate = (car) => {
    if (!car) {
        return null;
    }

    if (car.images && car.images < 1 ) {
        car.images = ["default.png"];
    }

    return `<tr>
                <td class="td.item text-center"> <div class='td-item-center'>${car.id}</div> </td>
                <td class="td.item text-center"> 
                    <div class='p-2 flex justify-content-center align-items-center'>
                        <img src="${WWWROOTPATH}images/cars/${car.images[0]}" class="max-w-3rem border-circle">
                    </div>
                </td>
                <td class="td.item text-center"> <div class='td-item-center'>${car.name}</div> </td>
                <td class="td.item text-center"> <div class='td-item-center'>${car.code}</div> </td>
                <td class="td.item text-center"> <div class='td-item-center'>${car.fuel}</div> </td>
                <td class="td.item text-center"> <div class='td-item-center'>${car.kilometers} KM</div> </td>
                <td class="td.item text-center"> <div class='td-item-center'>${car.year}</div> </td>
                <td class="td.item text-center"> <div class='td-item-center'>R$ ${car.price} </div></td>
                <td style='background-color: ${car.color};'></td>
                <td class="td-item"> 
                    <div class="flex justify-content-center align-items-center column-gap-4">
                        <a onclick='edit(${car.id})' data-bs-toggle="tooltip" title="Editar"> <i class="fa-regular fa-pen-to-square"></i></a> 
                        <a onclick='delete_(${car.id})' data-bs-toggle="tooltip" title="Deletar"> <i class="fa-regular fa-trash-can"></i> </a>
                    </div>
                </td>
            </tr>`;
}

const fillTable = (cars) => {
    const line = $("#result")[0];

    if (!cars) {
        line.innerHTML = null;
        return;
    }

    if (cars.length === 0) {
        line.innerHTML = "<td> <td colspan='10' class='text-center'>Nenhum registro encontrado</td> </tr>";
        return;
    }

    for (let car of cars) {
        line.innerHTML += carBoilerPlate(car);
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

//#endregion

//#region 'Form'

const applyImages = (car) => {
    let imagesElement = "";

    if (car.images && car.images < 1 ) {
        car.images = ["default.png", "netcar-ban.png"];
    }

    car.images.forEach((image, index) => {
        const id = Math.pow(index, Math.random() + 1).toString() + Date.now().toString();
        const imagePath = `${WWWROOTPATH}images/cars/${image}`;
        imagesElement += `
            <div class='carousel-item ${index === 0 ? 'active' : ''}'>
                <img id='${id}' src='${imagePath}'  onclick="editImage('${id}')" class='card-img-top cars'>
            </div>
        `;
    });

    return imagesElement
}



const fillCarousel = (car) => {
    const container = $("#images-container")[0];
    
    if (!car) {
        container.classList.add("d-none");
        return;
    }

    if (car.images.length === 0) {
        car.images = ["default.png", "netcar-ban.png"];
    }
    
    const carousel = $("#carousel-images")[0];
    if (car.images && car.images.length >= 1) {
        container.classList.remove("d-none");
        carousel.innerHTML = `
        <div id='${car.id}-${car.price}-${Date.now()}' class='carousel slide'>
            <div class='carousel-inner'>
                ${applyImages(car)}
            </div>
            <button class='carousel-control-prev' type='button' data-bs-target='#${car.id}-${car.price}-${Date.now()}' data-bs-slide='prev'>
                <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Previous</span>
            </button>
            <button class='carousel-control-next' type='button' data-bs-target='#${car.id}-${car.price}-${Date.now()}' data-bs-slide='next'>
                <span class='carousel-control-next-icon' aria-hidden='true'></span>
                <span class='visually-hidden'>Next</span>
            </button>
        </div>`;
        console.log(carousel.innerHTML);

    } else {
        container.classList.add("d-none");
    }
}

const setState = (label, _callback) => {
    $("#formModalLabel")[0].innerHTML = label;
    callback = _callback;
    $("#modal").click();
}

const checkState = () => {
    let state = true;
    for (let item in form.fields) {
        if (!form.fields[item].valid) {
            state = false;
        }
    }

    form.valid = state;
    return state;
}

const checkForm = (button) => {
    const formGroup = $("#form")[0]

    for (let prop in form.fields) {
        field = form.fields[prop]
        field.value = formGroup[prop].value;
        const errorMessage = $(".feedback" + prop)[0];
        
        switch (field.type) {
            case 'regex': 
                field.valid = field.value.match(field.validator) && field.value.match(field.validator).length >= 1
                break;
            case 'date': 
                field.valid = field.validator - new Date(formGroup[prop].value).getFullYear() >= 17 && field.validator - new Date(formGroup[prop].value).getFullYear() < 100
                break;
            case 'minLength': 
                field.valid = formGroup[prop].value.toString().length >= field.validator 
                break;
            case 'reference': 
                field.valid = formGroup[prop].value === $(`#${field.validator}`)[0].value
                break;
            default:
                field.valid = true;
        }
    
        if (!field.valid ) {
            errorMessage.innerHTML = field.message;
        } else if (errorMessage && !form.valid){
            errorMessage.innerHTML = "";
        }
    
        button.prop("disabled", !checkState());
    }
}

const fillForm = (car) => {
    const form_ = $("#form")[0];
    for (let field in car) {
        if (field === "images") continue

        if (form_[field]) {
            form_[field].value = car[field];
            form.fields[field].value = car[field];
        }
    }
    
}

const catchError = (response) => {
    for (let prop in form.fields) {
        const len = response.split(" ");
        if (`'${prop}'` === len[len.length - 1]) {
            return form.fields[prop];
        }
    }
    return undefined;
}

const resetForm = () => {
    for (let field in form.fields) {
        console.log(field);
        // $("#form")[0][field].value = null;
    }
} 

const form = {
    valid : false,
    fields : {
        id: {value: '', name: "id", type: null, valid: true},
        id_model: {value: '', name: "id_model", type: null, valid: true},
        code: {value: '', name: "code", type: null, valid: true},
        price: {value: '', name: "price", type: null, valid: true},
        fuel: {value: '', name: "fuel", type: null, valid: true},
        year: {value: '', name: "year", type: null, valid: true},
        kilometers: {value: '', name: "kilometers", type: null, valid: true},
        color: {value: '', name: "color", type: null, valid: true},
        name: {value: '', name: "name", type: null, valid: true}
    }
}

const getResources = () => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "car.php",
            data: "type=resources",
            async: true,
            success : (response) => {
                setupResources(JSON.parse(response))
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

const setupResources = (resources) => {
    const resourcesLabel = ["model", "fuel"]
    resources.fuel = fuelTypes;

    for (const resource of resourcesLabel) {
        const element = $("#" + resource)[0];
        if (resources[resource] && resources[resource].length) {
            resources[resource].forEach(value => {
                element.innerHTML += ` <option class='p-2' id="${value.id}" value="${resource === 'fuel' ? value.name : value.id}"> <div> ${value.name} - ${value.code} </div> </option> `;
            })
        } else {
            element.innerHTML += "<option disabled>Nenhum valor</option>";
        }
    }

    const itemElement = $("#item")[0];
    console.log(itemElement);
    resources["item"].forEach(item => {
        itemElement.innerHTML += `
        <div class='col-6'>
            <input class="form-check-input" type="checkbox" value="" id="${item.id}" onclick="handleItem(${item.id})">
            <label class="form-check-label" for="${item.id}"> ${item.name} </label>
        </div>`;
    })

    if (!resources["item"].length) {
        itemElement.innerHTML += `<div class='col-12'> <span class="text-sm font-medium"> <i class="fa-regular fa-circle-xmark"></i> Nenhum item cadastrado </span> </div>`;
    }

}

const fillSelectColor = () => {
    let options = "";
    for (let color in comumColors) {
        options += `
            <option value="${comumColors[color]}"> 
                <div class='flex align-items-center justify-content-center gap-2'>
                 <span class='border-circle p-2' style='background: #${comumColors[color]}'></span> 
                 <span>${color}</span> 
                </div>   
            </option>
        `;
    } return "<select class='form-select' id='select' name='color'>" + options + "</select>";
}

const comumColors = {
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

const toggleColorSelector = (type) => {
    const divInput = $("#colorInput")[0];
    if (type === "picker") {
        $("#select")[0]?.remove();
        divInput.innerHTML = inputs.picker;
    } else {
        $("#picker")[0]?.remove();
        divInput.innerHTML = inputs.select;
    }

}

const fuelTypes = [
    {id: 0, code: "ET", name: "Etanol"},
    {id: 1, code: "GA", name: "Gasolina"},
    {id: 2, code: "DS", name: "Diesel"},
    {id: 3, code: "FX", name: "Flex"},
]

let inputs = {
    current : "picker",
    picker: "<input  type='color' class='form-control' id='picker' name='color' placeholder='Escolha uma cor'>",
    select: fillSelectColor()
}

let handleItem = (item, event) => {
    if (event) {
        event.preventDefault();
    }
    if (items.includes(item)) {
        items = items.filter(it => it != item);
    } else {
        items.push(item);
    }
    console.log(items);
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
    getResources().then(r => {})
    getCars(encodeURI("method=GET"))
        .then(resp => fillTable(resp))
        .catch(resp => console.warn(resp))

    toggleColorSelector("select")
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

    // $("#close").on("click", ev => {
    //     fillCarousel(null)
    // })
    // $("#btn-close").on("click", ev => {
    //     fillCarousel(null)
    // })
    
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