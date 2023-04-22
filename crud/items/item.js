const getBrands = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "item.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
                items = JSON.parse(response);
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

const setUser = (item) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "POST",
            url: "item.php",
            data: item,
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

const deleteUser = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "DELETE",
            url: "item.php/" + id,
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
    setState("Cadastrar Item", () => {

        $.ajax({
            type: "POST",
            url: "item.php",
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

                        getBrands(encodeURI("method=GET"))
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
    const item = items.find(item => item.id == id);
    fillForm(item)
    setState("Editar Item", () => {
        console.log(item, $("#form").serialize() ,items);
        $.ajax({
            type: "POST",
            url: "item.php",
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

                        getBrands()
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
            deleteUser(encodeURI(`id=${id}`))
            .then(response => {
                
                if (response.success) {
                    getBrands()
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

const userBoilerPlate = (item) => {
    if (!item) {
        return null;
    }

    return `<tr>
                <td class="valign-center text-center">${item.id}</td>
                <td class="valign-center text-center">${item.name}</td>
                <td class="valign-center text-center">${item.code}</td>
                <td class="valign-center text-center">${item.description}</td>
                <td class="flex justify-content-center align-items-center column-gap-4"> 
                    <a onclick='edit(${item.id})' data-bs-toggle="tooltip" title="Editar"> <i class="fa-regular fa-pen-to-square"></i></a> 
                    <a onclick='delete_(${item.id})' data-bs-toggle="tooltip" title="Deletar"> <i class="fa-regular fa-trash-can"></i> </a>
                </td>
            </tr>`;
}

const fillTable = (items) => {
    const line = $("#result")[0];

    if (!items) {
        line.innerHTML = null;
        return;
    }

    if (items.length === 0) {
        line.innerHTML = "<td> <td colspan='6' class='text-center'>Nenhum registro encontrado</td> </tr>";
        return;
    }

    for (let item of items) {
        line.innerHTML += userBoilerPlate(item);
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

const fillForm = (item) => {
    const form_ = $("#form")[0];
    for (let field in item) {
        if (form_[field]) {
            form_[field].value = item[field];
            form.fields[field].value = item[field];
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
        name : {value: '', name: "Nome", type: 'regex', validator: /^[0-9a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{3,}/g, valid: false, message: "Nome inválido"}, 
        code : {value: '', name: "Código", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{2,}/g, valid: false, message: "Código inválido"}, 
        description : {value: '', name: "Descrição", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ ]{8,}/g, valid: false, message: "Descrição curta"}, 
    }
}

//#endregion

let items = []
let callback;

const Toast = Swal.mixin({
    toast: true,
    timer: 3000,
    position: 'bottom-end',
    showConfirmButton: false,
    timerProgressBar: true,
})



$(window).on("load", ev => {
    getBrands(encodeURI("method=GET"))
        .then(resp => fillTable(resp))
        .catch(resp => console.warn(resp))
 
})

$(document).ready(() => {
    $("#keyword").on("keyup", ({target}) => {
        getBrands(encodeURI(`keyword=${target.value}&method=GET`))
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

