const getUsers = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "model.php",
            data: id ? id : null,
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

const setUser = (user) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "POST",
            url: "model.php",
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
            url: "model.php",
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

const userBoilerPlate = (user) => {
    if (!user) {
        return null;
    }

    return `<tr>
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.surname}</td>
                <td>${user.email}</td>
                <td>${user.phone}</td>
                <td>${user.cpf}</td>
                <td> <i class='fa-solid fa-edit'></i> </td>
                <td> <i class='fa-solid fa-trash'></i> </td>
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

$(window).on("load", ev => {
    getUsers()
        .then(resp => fillTable(resp))
        .catch(resp => console.warn(resp))
 
})

$(document).ready(() => {
    const load = $("#searchBtn");
    load.click(event => {
        var data = $("#search").serialize();
        console.log(data);
        getUsers(data)
            .then(resp => {
                console.log(resp);
                fillTable(null);
                fillTable(resp);
            })

    })

    $("#new").click( async () => {

        

    })
})