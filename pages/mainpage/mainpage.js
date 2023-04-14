$(document).ready(() => {
    const logout = $("#logout");
    const Toast = Swal.mixin({
        toast: true,
        timer: 2000,
        position: 'bottom-end',
        showConfirmButton: false,
        timerProgressBar: true,
    })

    if (logout) {
        logout.click(ev => {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                  confirmButton: 'btn btn-success mr-1',
                  cancelButton: 'btn btn-danger ml-1'
                },
              })
              
              swalWithBootstrapButtons.fire({
                title: 'Deseja sair ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                    Toast.fire({
                        icon: 'warning',
                        title: 'Saindo!',
                        text: 'Até logo...' 
                    })
                    setTimeout(_ => location.assign(location.href + '?logout=1'), 1000)
                } 
              })
        })
    }
})