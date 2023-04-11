
let form = {
    valid : false,
    fields : {
        email : {value: '', type: 'minLength', validator: 10, valid: false},
        password : {value: '', type: 'minLength', validator: 6, valid: false},
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
    console.log('ready');
    const button = $("#login-button");

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
            button.prop("disabled", !checkState());
        })
    }

    button.click(event => {
        var data = $("#login").serialize();
        // console.log($("#default"), $("#loading"));

        $("#default")[0].classList.add("d-none")
        $("#loading")[0].classList.remove("d-none");
        button.prop("disabled", true);

        $.ajax({
            type: "POST",
            // dataType: "json",
            url: "login.php",
            async:true,
            data: data,
            success: function (response) {
                console.log(response);
                setTimeout(function () {
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
                    button.prop("disabled", false);
                }, new Date().getMilliseconds()) ;

                // setTimeout(() => location.assign(location.origin + "/netcar/pages/mainpage") ,777)
            }
        })
    })
})