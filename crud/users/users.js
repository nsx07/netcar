//#region Members 'API Methods'

const getEntities = (id) => {
    
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "users.php",
            data: id,
            async: true,
            success : (response) => {
                // console.log(response);
                users = JSON.parse(response);
                fillTable(users);
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })


    return promise
}

const deleteEntity = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "DELETE",
            url: "users.php/" + id,
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
    setState("Cadastrar usuário", () => {

        $.ajax({
            type: "POST",
            url: "users.php",
            async:true,
            data: $("#signup").serialize(),
            success: function (response) {
                // console.log(response);
                try {
                    response = JSON.parse(response);

                    if (response.success) {
                          
                        Toast.fire({
                            icon: 'success',
                            title: 'Cadastrado com sucesso!'
                        })

                        getEntities()
                        .then(resp => {
                           

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
    const user = users.find(user => user.id == id);
    fillForm(user)
    form.fields.phone.validator = 11;
    form.fields.cpf.validator = 11;

    $("#phone").on("change", ev => {
        console.log(ev);
        form.fields.phone.validator = 15;
    })
    $("#cpf").on("change", ev => {
        console.log(ev);
        form.fields.cpf.validator = 14;
    })

    setState("Editar usuário", () => {
        var serialize = $("#signup").serialize();
        serialize += changePassword ? "&changePass=true" : "&changePass=false";

        console.log(serialize);
        $("#phone").off("change");

        $("#cpf").off("change");

        $.ajax({
            type: "POST",
            url: "users.php",
            async:true,
            data: serialize,
            success: function (response) {
                console.log(response);
                try {
                    response = JSON.parse(response);

                    if (response.success) {
                          
                        Toast.fire({
                            icon: 'success',
                            title: 'Atualizado com sucesso!'
                        })

                        getEntities()
                        .then(resp => {
                           

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

//#endregion

//#region Members 'Utils'

const setState = (label, _callback) => {
    $("#formModalLabel")[0].innerHTML = label;
    callback = _callback;
    operation = label;
    $("#modal").click();
}

const confirmDelete = (id) => {
    Swal.fire({
        title: 'Deseja excluir?',
        showDenyButton: true,
        confirmButtonText: 'Confirmar',
        denyButtonText: `Cancelar`,
      }).then((result) => {
        if (result.isConfirmed) {
            deleteEntity(encodeURI(`id=${id}`))
            .then(response => {
                
                if (response.success) {
                    getEntities()
                    .then(resp => {

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

const catchError = (response) => {
    for (let prop in form.fields) {
        const len = response.split(" ");
        if (`'${prop}'` === len[len.length - 1]) {
            return form.fields[prop];
        }
    }
    return undefined;
}

const userBoilerPlate = (user) => {
    if (!user) {
        return null;
    }

    let options = `<td class="valign-center text-center" data-bs-toggle="tooltip" title="Altere as suas informações no perfil"> 
                        <i class="fa-solid fa-circle-info" style="color: var(--main-color);"></i>
                  </td>`;

    if (user.id !== JSON.parse(sessionStorage.getItem("user")).id) {
        options = 
            `<td class="flex justify-content-center align-items-center column-gap-4"> 
                <a onclick='edit(${user.id})' data-bs-toggle="tooltip" title="Editar"> <i class="fa-regular fa-pen-to-square"></i></a> 
                <a onclick='confirmDelete(${user.id})' data-bs-toggle="tooltip" title="Deletar"> <i class="fa-regular fa-trash-can"></i> </a>
            </td>`;
    }

    return `<tr>
                <td class="valign-center text-center">${user.id}</td>
                <td class="valign-center text-center">${user.name}</td>
                <td class="valign-center text-center">${user.surname}</td>
                <td class="valign-center text-center">${user.email}</td>
                <td class="valign-center text-center">${user.phone}</td>
                <td class="valign-center text-center">${user.cpf}</td>
                ${options}
            </tr>`;
}

const fillTable = (users) => {
    const line = $("#result")[0];

    if (!users) {
        line.innerHTML = null;
        return;
    }

    if (users.length === 0) {
        line.innerHTML = "<td> <td colspan='6' class='text-center'>Nenhum registro encontrado</td> </tr>";
        return;
    }

    if (users && users.length) {
        line.innerHTML = null;
    }
    
    for (let user of users) {
        line.innerHTML += userBoilerPlate(user);
    }

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
}

//#endregion

//#region Members 'Form'

const handleZipCode = (event) => {
    let input = event.target
    input.value = zipCodeMask(input.value)
}
  
const zipCodeMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g,'')
    value = value.replace(/(\d{5})(\d)/,'$1-$2')
    return value
}

const mascaraCPF = (cpf) => {
    cpf = cpf.replace(/\D/g, ""); // remove todos os caracteres não numéricos
    cpf = cpf.substring(0,3) + '.' + cpf.substring(3,6) + '.' + cpf.substring(6,9) + '-' + cpf.substring(9);
    
    return cpf;
}

const mascaraTelefone = (telefone) => {
    telefone = telefone.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2'); // Adiciona parênteses em volta dos primeiros 2 dígitos
    telefone = telefone.replace(/(\d)(\d{4})$/, '$1-$2'); // Adiciona hífen entre o quinto e sexto dígitos
    return telefone;
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

const checkForm = (button, skipPass = false) => {
    const formGroup = $("#signup")[0]

    for (let prop in form.fields) {

        if (skipPass) {
            if (prop === "confirmPass" || prop === "password") {
                continue;
            }
        }

        field = form.fields[prop]
        field.value = removeGarbbage(formGroup[prop].value);
        const errorMessage = $(".feedback" + prop)[0];

        
        switch (field.type) {
            case 'regex': 
                const regex = new RegExp(field.validator);
                field.valid = field.value.match(regex) && field.value.match(regex).length >= 1
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
            case 'notEqual':
                field.valid = formGroup[prop].value !== field.validator;
                break;
            default:
                field.valid = true;
        }

        field.valid = field.valid === null ? false : field.valid;
        console.log(prop, field.valid);
    
        if (!field.valid ) {
            errorMessage.innerHTML = field.message;
        } else if (errorMessage && !form.valid){
            errorMessage.innerHTML = "";
        }
    
        button.prop("disabled", !checkState());
    }
}

const fillForm = (user) => {
    const form_ = $("#signup")[0];
    for (let field in user) {
        if (form_[field]) {
            form_[field].value = user[field];
            form.fields[field].value = user[field];
        }
    }
    
    form_["confirmPass"].value = user.password;
    form.fields["confirmPass"].value = user.password;
}

const removeGarbbage = (content) => {
    content = content.replaceAll("(","")
    content = content.replaceAll(")","")
    content = content.includes("@") ? content : content.replaceAll(".","")
    content = content.replaceAll("-","")
    content = content.replaceAll(" ","")   
    return content
}

const resetForm = () => {
    for (let field in form.fields) {
        $("#signup")[0][field].value = null;
        if (field in form.fields) {
            form.fields[field].value = form.fields[field].defaultValue ?? null;
        }
    }

    $("#id_access")[0].selectedIndex = 0;
    $("#changePass")[0]
} 

const form = {
    valid : false,
    fields : {
        id : {value: '', name: "id", type: null, valid: true},
        id_access: {value: '0', defaultValue: '0', type: 'notEqual', validator: '0', name: "Acesso", valid: false, message: "Selecione o tipo de usuário"},
        name : {value: '', name: "Nome", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{3,}/g, valid: false, message: "Nome inválido"},
        surname : {value: '', name: "Sobrenome", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{3,}/g, valid: false, message: "Sobrenome inválido"},
        birthDate: {value: '', name: "Data nascimento", type: 'date', validator: new Date().getFullYear(), valid: false, message: "Informe uma data válida"},
        email : {value: '', name: "Email", type: 'regex', validator: /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/g, valid: false, message: "Email inválido"},
        cpf : {value: '', name: "Cpf", type: 'minLength', validator: 11, valid: false, message: "Preencha o cpf"},
        phone : {value: '', name: "Telefone", type: 'minLength', validator: 11, valid: false, message: "Informe o telefone"},        
        password : {value: '', name: "Senha", type: 'regex', validator: /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_]).{8,}$/g, valid: false, message: "<p class='text-sm mb-1'> Senha deve ter no mínimo: <br> • 1 letra maiscula <br> • 1 número <br> • 1 carecter especial <br> • 8 caracteres </p>"},
        confirmPass : {value: '', name: "Confirma senha", type: 'reference', validator : "password", valid: false, message: "Senhas não batem"} 
    }
}

//#endregion

let users = []
let callback;
let operation; 
let changePassword = false;

const Toast = Swal.mixin({
    toast: true,
    timer: 3000,
    position: 'bottom-end',
    showConfirmButton: false,
    timerProgressBar: true,
})

$(window).on("load", async ev => {
    await getEntities()
})

$(document).ready(() => {
    $("#keyword").on("keyup", async ({target}) => {
        await getEntities(encodeURI(`keyword=${target.value}`))
    })

    const changePass = $("#changePass");
    const button = $("#save");

    $("#modal").on("click", ev => {
        // changePass.click();
        if (operation === "Editar usuário") {
            $("#changePassDiv")[0].classList.remove("d-none")
            if (!changePassword) {
                form.fields.password.valid = true
                form.fields.confirmPass.valid = true
                $("#password").prop("disabled", !changePassword);
                $("#confirmPass").prop("disabled", !changePassword);
                checkForm(button, true);
            }

        } else {
            $("#changePassDiv")[0].classList.add("d-none");
            $("#password").prop("disabled", false);
            $("#confirmPass").prop("disabled", false);
            changePassword = true;
        }
    })

    changePass.on("change", ev => {
        changePassword = !changePassword;

        if (!changePassword) {
            form.fields.password.valid = true
            form.fields.confirmPass.valid = true
            checkForm(button, true);
            $("#password").prop("disabled", true);
            $("#confirmPass").prop("disabled", true);
            $(".feedbackpassword")[0].innerHTML = "";
            $(".feedbackconfirmPass")[0].innerHTML = ""
        } else {
            form.fields.password.valid = false
            form.fields.confirmPass.valid = false
            $("#password").prop("disabled", false);
            $("#confirmPass").prop("disabled", false);
            checkForm(button);
        }

    })
    
    $("#signup").on("keyup", ev => checkForm(button, !changePassword))
    $("#signup").on("click", ev => checkForm(button, !changePassword))

    button.click(event => {
        $("#default")[0].classList.add("d-none")
        $("#loading")[0].classList.remove("d-none");
        button.prop("disabled", true);

        callback();
                        
        $("#default")[0].classList.remove("d-none")
        $("#loading")[0].classList.add("d-none");
    })
})