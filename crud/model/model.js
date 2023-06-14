const getModels = (id) => {
    const promise = new Promise(async (res,rej) => {
        load(true);
        await $.ajax({
            method: "GET",
            url: "model.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
                models = JSON.parse(response);
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            },
            complete: () => load(false)
        })
    })

    return promise
}

const setmodel = (model) => {
    const promise = new Promise(async (res,rej) => {
        load(true);
        await 
        $.ajax({
            method: "POST",
            url: "model.php",
            data: model,
            async: true,
            success : (response) => {
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            },
            complete: () => load(false)
        })
    })

    return promise
}

const deletemodel = (id) => {
    const promise = new Promise(async (res,rej) => {
        load(true);
        await 
        $.ajax({
            method: "DELETE",
            url: "model.php/" + id,
            data: id,
            async: true,
            success : (response) => {
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            },
            complete: () => load(false)
        })
    })

    return promise
}

const newEntity = () => {
    resetForm();
    setState("Cadastrar Modelo", () => {
        load(true);
        $.ajax({
            type: "POST",
            url: "model.php",
            async:true,
            data: $("#form").serialize(),
            success: function (response) {
                try {
                    response = JSON.parse(response);

                    if (response.success) {
                          
                        Toast.fire({
                            icon: 'success',
                            title: 'Cadastrado com sucesso!'
                        })

                        getModels(encodeURI("method=GET"))
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
            },
            complete: () => load(false)
        })

    })
}

const edit = (id) => {
    const model = models.find(model => model.id == id);
    fillForm(model)
    setState("Editar Modelo", () => {
        load(true);
        $.ajax({
            type: "POST",
            url: "model.php",
            async:true,
            data: $("#form").serialize(),
            success: function (response) {
                try {
                    response = JSON.parse(response);

                    if (response.success) {
                          
                        Toast.fire({
                            icon: 'success',
                            title: 'Atualizado com sucesso!'
                        })

                        getModels()
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
            },
            complete: () => load(false)
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
            deletemodel(encodeURI(`id=${id}`))
            .then(response => {
                
                if (response.success) {
                    getModels()
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

const modelBoilerPlate = (model) => {
    if (!model) {
        return null;
    }

    return `<tr>
                <td class="valign-center text-center">${model.id}</td>
                <td class="valign-center text-center">${model.name}</td>
                <td class="valign-center text-center">${model.code}</td>
                <td class="valign-center text-center">${model.description}</td>
                <td class="valign-center text-center">${model.name_brand}</td>
                <td class="flex justify-content-center align-items-center column-gap-4"> 
                    <a onclick='edit(${model.id})' data-bs-toggle="tooltip" title="Editar"> <i class="fa-regular fa-pen-to-square"></i></a> 
                    <a onclick='delete_(${model.id})' data-bs-toggle="tooltip" title="Deletar"> <i class="fa-regular fa-trash-can"></i> </a>
                </td>
            </tr>`;
}

const fillTable = (models) => {
    const line = $("#result")[0];

    if (!models) {
        line.innerHTML = null;
        return;
    }

    if (models.length === 0) {
        line.innerHTML = "<td> <td colspan='6' class='text-center'>Nenhum registro encontrado</td> </tr>";
        return;
    }

    for (let model of models) {
        line.innerHTML += modelBoilerPlate(model);
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

const fillForm = (model) => {
    const form_ = $("#form")[0];
    for (let field in model) {
        if (form_[field]) {
            form_[field].value = model[field];
            form.fields[field].value = model[field];
        }
    }
    
}

const getResources = () => {
    const promise = new Promise(async (res,rej) => {
        load(true);
        await 
        $.ajax({
            method: "GET",
            url: "model.php",
            data: "type=resources",
            async: true,
            success : (response) => {
                setupResources(JSON.parse(response))
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            },
            complete: () => load(false)
        })
    })

    return promise
}

const setupResources = (resources) => {
    const resourcesLabel = ["brand"];

    for (const resource of resourcesLabel) {
        const element = $("#" + resource)[0];
        if (resources && resources.length) {
            resources.forEach(value => {
                element.innerHTML += ` <option class='p-2' id="${value.id}" value="${value.id}"> <div> ${value.name} - ${value.description} </div> </option> `;
            })
        } else {
            element.innerHTML += "<option disabled>Nenhum valor</option>";
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
    fields : {
        id : {value: '', name: "id", type: null, valid: true},
        brand : {value: '', name: "Marca", type: null, valid: true},
        name : {value: '', name: "Nome", type: 'regex', validator: /^[0-9a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{3,}/g, valid: false, message: "Nome inválido"}, 
        code : {value: '', name: "Código", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{2,}/g, valid: false, message: "Código inválido"}, 
        description : {value: '', name: "Descrição", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{8,}/g, valid: false, message: "Descrição curta"}, 
    }
}

//#endregion

let models = []
let callback;

$(window).on("load", ev => {
    getResources().then(r => {})
    getModels(encodeURI("method=GET"))
        .then(resp => fillTable(resp))
        .catch(resp => console.warn(resp))
 
})

$(document).ready(() => {
    $("#keyword").on("keyup", ({target}) => {
        getModels(encodeURI(`keyword=${target.value}&method=GET`))
        .then(resp => {
            fillTable(null);
            fillTable(resp);
        })
    })
    

    const button = $("#save");
    
    $("#form").on("keyup", ev => checkForm(button))
    $("#form").on("click", ev => checkForm(button))

    button.click(event => {
        $("#default")[0].classList.add("d-none")
        $("#loading")[0].classList.remove("d-none");
        button.prop("disabled", true);

        callback();
                        
        $("#default")[0].classList.remove("d-none")
        $("#loading")[0].classList.add("d-none");
    })
})

