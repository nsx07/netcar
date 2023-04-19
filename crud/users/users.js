const getUsers = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "users.php",
            data: id ? id : null,
            async: true,
            success : (response) => {
                users = JSON.parse(response);
                res(JSON.parse(response))
            },
            error : (response) => {
                rej(JSON.parse(response))
            }
        })
    })

    return promise
}

const setUser = (user) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "POST",
            url: "users.php",
            data: user,
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

const edit = (id) => {
    const user = users.find(user => user.id);
    fillForm(user)
    console.log($("#signup"));
    
    $("#new").click();
}

const fillForm = (user) => {
    const form = $("#signup")[0];
    $(".label-modal")[0].innerHTML = "Editar usuário";

    for (let field in user) {
        if (form[field]) {
            
            form[field].value = user[field];
        }
    }
    
    form["confirmPass"].value = user.password;

}

const delete_ = (id) => {
    deleteUser(encodeURI(`id=${id}`))
        .then(resp => console.log(resp))
        .catch(resp => console.log(resp))
}

const userBoilerPlate = (user) => {
    if (!user) {
        return null;
    }

    return `<tr>
                <td class="valign-center text-center">${user.id}</td>
                <td class="valign-center text-center">${user.name}</td>
                <td class="valign-center text-center">${user.surname}</td>
                <td class="valign-center text-center">${user.email}</td>
                <td class="valign-center text-center">${user.phone}</td>
                <td class="valign-center text-center">${user.cpf}</td>
                <td class="flex justify-content-center align-items-center column-gap-4"> 
                    <a onclick='edit(${user.id})'> <i class='fa-solid fa-edit'></i>  </a>
                    <a onclick='deleteUser(${user.id})'> <i class='fa-solid fa-trash'></i>  </a>
                </td>
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

    for (let user of users) {
        line.innerHTML += userBoilerPlate(user);
    }
}

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

const getCepInfo = (cep) => {
    return `https://cdn.apicep.com/file/apicep/${cep}.json`;
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

const removeGarbbage = (content) => {

    content = content.replaceAll("(","")
    content = content.replaceAll(")","")
    content = content.includes("@") ? content : content.replaceAll(".","")
    content = content.replaceAll("-","")
    content = content.replaceAll(" ","")
    
    return content
}

const parseUser = (response) => {
    const userObj = {};
    for (let prop in response) {
        userObj[prop] = response[prop]
    }
    sessionStorage.setItem("user", JSON.stringify(userObj));
    return userObj;
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

const form = {
    valid : false,
    fields : {
        name : {value: '', name: "Nome", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{3,}/g, valid: false, message: "Nome inválido"},
        surname : {value: '', name: "Sobrenome", type: 'regex', validator: /^[a-zA-ZzáàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]{3,}/g, valid: false, message: "Sobrenome inválido"},
        birthDate: {value: '', name: "Data nascimento", type: 'date', validator: new Date().getFullYear(), valid: false, message: "Informe uma data válida"},
        email : {value: '', name: "Email", type: 'regex', validator: /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/g, valid: false, message: "Email inválido"},
        cpf : {value: '', name: "Cpf", type: 'minLength', validator: 11, valid: false, message: "Preencha o cpf"},
        phone : {value: '', name: "Telefone", type: 'minLength', validator: 11, valid: false, message: "Informe o telefone"},        
        password : {value: '', name: "Senha", type: 'minLength', validator: 6, valid: false, message: "Senha deve ter 6 caracteres"},
        confirmPass : {value: '', name: "Confirma senha", type: 'reference', validator : "password", valid: false, message: "Senhas não batem"} 
    }
}

let users = []

$(window).on("load", ev => {
    getUsers(encodeURI("method=GET"))
        .then(resp => fillTable(resp))
        .catch(resp => console.warn(resp))
 
})

$(document).ready(() => {
    const filter = $("#keyword");
    filter.on("keyup", ({target}) => {
        console.log(target.value);
        getUsers(encodeURI(`keyword=${target.value}&method=GET`))
        .then(resp => {
            console.log(resp);
            fillTable(null);
            fillTable(resp);
        })
    })

    const button = $("#addNew");

    for (let prop in form.fields) {
        
        $(`#${prop}`).on("change", (event) => {
            field = form.fields[prop]
            field.value = removeGarbbage(event.target.value);
            const errorMessage = $(".feedback" + prop)[0];
            
            switch (field.type) {
                case 'regex': 
                    field.valid = field.value.match(field.validator) && field.value.match(field.validator).length >= 1
                    break;
                case 'date': 
                    field.valid = field.validator - new Date(event.target.value).getFullYear() >= 17 && field.validator - new Date(event.target.value).getFullYear() < 100
                    break;
                case 'minLength': 
                    field.valid = event.target.value.toString().length >= field.validator 
                    break;
                case 'reference': 
                    field.valid = event.target.value === $(`#${field.validator}`)[0].value
                    break;
            }

            if (!field.valid) {
                errorMessage.innerHTML = field.message;
            } else {
                errorMessage.innerHTML = "";
            }

            button.prop("disabled", !checkState());
        })
    }
    
    button.click(event => {
        const data = $("#signup").serialize();
        const Toast = Swal.mixin({
            toast: true,
            timer: 3000,
            position: 'bottom-end',
            showConfirmButton: false,
            timerProgressBar: true,
          })

        $("#default")[0].classList.add("d-none")
        $("#loading")[0].classList.remove("d-none");
        button.prop("disabled", true);


        $.ajax({
            type: "POST",
            url: "users.php",
            async:true,
            data: data,
            success: function (response) {
                console.log(response);
                try {
                    response = JSON.parse(response);

                    if (response.success) {
                        const user = parseUser(response);
                          
                        Toast.fire({
                            icon: 'success',
                            title: 'Cadastrado com sucesso!'
                        })

                        getUsers(encodeURI("method=GET"))
                        .then(resp => {
                            fillTable(null);
                            fillTable(resp)

                            $("#close").click();

                        })
                        .catch(resp => console.warn(resp))

                        // setTimeout(() => location.assign(location.origin + "/netcar/pages/mainpage") ,777)
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
                
                $("#default")[0].classList.remove("d-none")
                $("#loading")[0].classList.add("d-none");

            }
        })
    })
})

