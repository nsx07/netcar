const getUsers = (id) => {
    const promise = new Promise(async (res,rej) => {
        await 
        $.ajax({
            method: "GET",
            url: "users.php",
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

const userBoilerPlate = (user) => {
    console.log(user);
    const tr = `
        <tr>
            <td>${user.id}</td>
            <td>${user.name}</td>
            <td>${user.surName}</td>
            <td>${user.email}</td>
            <td>${user.phone}</td>
            <td>${user.cpf}</td>
            
            <td> <i class='fa-solid fa-edit'></i> </td>
            <td> <i class='fa-solid fa-trash'></i> </td>
        
        </tr>
    `;
    return tr;
}

const fillTable = (users) => {
    console.log(users)
    const line = $("#result")[0];

    for (let user of users) {
        line.innerHTML += userBoilerPlate(user);
    }

}

$(window).on("load", ev => {
    const users = [];

    getUsers()
        .then(resp => fillTable(resp))
        .catch(resp => console.warn(resp))
    
})

$(document).ready(() => {
    const load = $("#search");

    load.click(event => {
        
        var data = $("#search").serialize()
        getUsers(data)

    })

})