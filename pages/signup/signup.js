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

function mascaraCPF(cpf){
    cpf = cpf.replace(/\D/g, ""); // remove todos os caracteres não numéricos
    cpf = cpf.substring(0,3) + '.' + cpf.substring(3,6) + '.' + cpf.substring(6,9) + '-' + cpf.substring(9);
    
    return cpf;
}

function mascaraTelefone(telefone) {
    telefone = telefone.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
    telefone = telefone.replace(/^(\d{2})(\d)/g, '($1) $2'); // Adiciona parênteses em volta dos primeiros 2 dígitos
    telefone = telefone.replace(/(\d)(\d{4})$/, '$1-$2'); // Adiciona hífen entre o quinto e sexto dígitos
    return telefone;
}

const getCepInfo = (cep) => {
    return `https://cdn.apicep.com/file/apicep/${cep}.json`;
}

let form = {
    valid : false,
    fields : {
        name : {value: '', type: 'regex', validator: /[a-zA-Z]{3,}/g, valid: false},
        surName : {value: '', type: 'regex', validator: /[a-zA-Z]{3,}/g, valid: false},
        dateBirth: {value: '', type: 'date', validator: new Date().getFullYear(), valid: false},
        email : {value: '', type: 'minLength', validator: 10, valid: false},
        cpf : {value: '', type: 'minLength', validator: 11, valid: false},
        phone : {value: '', type: 'minLength', validator: 11, valid: false},        
        password : {value: '', type: 'minLength', validator: 6, valid: false},
        confirmPass : {value: '', type: 'reference', validator : "password", valid: false} 
    }
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

$(document).ready(() => {
    const button = $("#signup-button");
    for (let prop in form.fields) {
        
        $(`#${prop}`).on("change", (event) => {
            self = form.fields[prop]
            self.value = removeGarbbage(event.target.value);
            
            switch (self.type) {
                case 'regex': 
                    self.valid = true
                    break;
                case 'date': 
                    self.valid = self.validator - new Date(event.target.value).getFullYear() >= 17 && self.validator - new Date(event.target.value).getFullYear() < 100
                    break;
                case 'minLength': 
                    self.valid = event.target.value.toString().length >= self.validator 
                    break;
                case 'reference': 
                    self.valid = event.target.value === $(`#${self.validator}`)[0].value
                    break;
            }

            console.log(location);

            button.prop("disabled", !checkState());
        })
    }

    
    button.click(event => {
        var data = $("#signup").serialize();

        $("#default")[0].classList.add("d-none")
        $("#loading")[0].classList.remove("d-none");
        button.prop("disabled", true);

        $.ajax({
            type: "POST",
            // dataType: "json",
            url: "signup.php",
            async:true,
            data: data,
            success: function (response) {
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        console.log(response);
                        parseUser(response);
                        const toastLiveExample = document.getElementById('liveToast')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                        toastBootstrap.show()
                    } else {
                        alert(response);
                    }    
                } catch (error) {
                    alert(error);
                }
                
                $("#default")[0].classList.remove("d-none")
                $("#loading")[0].classList.add("d-none");

                // setTimeout(() => location.assign(location.origin + "/netcar/pages/mainpage") ,777)
            }
        })
    })
})
