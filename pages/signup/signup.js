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
        password : {value: '', name: "Senha", type: 'regex', validator: /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_]).{8,}$/g, valid: false, message: "<p class='text-sm mb-1'> Senha deve ter no mínimo: <br> • 1 letra maiscula <br> • 1 número <br> • 1 carecter especial <br> • 8 caracteres </p>"},
        confirmPass : {value: '', name: "Confirma senha", type: 'reference', validator : "password", valid: false, message: "Senhas não batem"} 
    }
}

$(document).ready(() => {
    const button = $("#signup-button");

    $("#password").on("keyup", ev => {
        let reg = new RegExp(/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*_]).{8,}$/g);
        console.log(ev.target.value.match(reg));
        console.log(ev.target.value);
    })

    for (let prop in form.fields) {
        
        $(`#${prop}`).on("change", (event) => {
            field = form.fields[prop]
            field.value = removeGarbbage(event.target.value);
            const errorMessage = $(".feedback" + prop)[0];
            
            switch (field.type) {
                case 'regex': 
                    const regex = new RegExp(field.validator);
                    field.valid = field.value.match(regex) && field.value.match(regex).length >= 1
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

        $("#default")[0].classList.add("d-none")
        $("#loading")[0].classList.remove("d-none");
        button.prop("disabled", true);
        const data = $("#signup").serialize();
        console.log(data);

        load(true);
        $.ajax({
            type: "POST",
            url: "signup.php",
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

                        setTimeout(() => location.assign(location.origin + "/netcar/pages/mainpage") ,777)
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

            },
            complete: () => load(false)
        })
    })
})
 