const getCars = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "car.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
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

const setCar = (car) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "POST",
            url: "car.php",
            data: car,
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
    setState("Cadastrar Carro", () => {

        $.ajax({
            type: "POST",
            url: "car.php",
            async:true,
            data: $("#form").serialize(),
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
    fillForm(car)
    setState("Editar Carro", () => {
        console.log(car, $("#form").serialize() ,cars);
        $.ajax({
            type: "POST",
            url: "car.php",
            async:true,
            data: $("#form").serialize(),
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

const carBoilerPlate = (car) => {
    if (!car) {
        return null;
    }

    return `<tr>
                <td class="valign-center text-center">${car.id}</td>
                <td class="valign-center text-center">${car.banner}</td>
                <td class="valign-center text-center">${car.name}</td>
                <td class="valign-center text-center">${car.model.code}</td>
                <td class="valign-center text-center">${car.brand.code}</td>
                <td class="valign-center text-center">${car.year}</td>
                <td class="valign-center text-center">R$ ${car.price}</td>
                <td class="flex justify-content-center align-items-center column-gap-4"> 
                    <a onclick='edit(${car.id})' data-bs-toggle="tooltip" title="Editar"> <i class="fa-regular fa-pen-to-square"></i></a> 
                    <a onclick='delete_(${car.id})' data-bs-toggle="tooltip" title="Deletar"> <i class="fa-regular fa-trash-can"></i> </a>
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
        line.innerHTML = "<td> <td colspan='8' class='text-center'>Nenhum registro encontrado</td> </tr>";
        return;
    }

    for (let car of cars) {
        line.innerHTML += carBoilerPlate(car);
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

//#region 'Form'

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
        $("#form")[0][field].value = null;
    }
} 

const form = {
    valid : false,
    fields : { }
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
                // console.log(response);
                console.log(JSON.parse(response));
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
    const resourcesLabel = ["model", "brand","item"];

    for (const resource of resourcesLabel) {
        const element = $("#" + resource)[0];
        if (resources[resource] && resources[resource].length) {
            resources[resource].forEach(value => {
                element.innerHTML += ` <option class='p-2' id="${value.id}" value="${value.id}"> <div> ${value.name} - ${value.description} </div> </option> `;
            })
        } else {
            element.innerHTML += "<option disabled>Nenhum valor</option>";
        }
    }
}

//#endregion

let callback;
let cars = [];
let items = []
let brands = [];
let models = [];
let handleItem = (item) => {
    const element = $("#" + item)[0].classList;
    if (items.includes(item)) {
        items = items.filter(it => it != item);
        element.remove("active");
    } else {
        items.push(item);
        element.add("active")
    }
}

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

        const formData = new FormData($("#files")[0]);

        $.ajax({
            type: "POST",
            async:true,
            url: "car.php",
            data: $("#form").serialize(),
            success: function (response) {
                console.log(response);
                $.ajax({
                    type: "POST",
                    async: true,
                    url: "car.php",
                    data: formData,
                    success: (responseImage) => {
                        console.log(responseImage);
                    }
                })
            }
        })
        
        // callback();
                        
        $("#default")[0].classList.remove("d-none")
        $("#loading")[0].classList.add("d-none");
    })
})

