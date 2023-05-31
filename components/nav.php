  <nav class="navbar bg-body-tertiary shadow justify-content-between px-3">
      <?php 
        if (isset($_GET["logout"])) {
          $_SESSION = array();

          session_destroy();
          header("Location: /netcar/pages/mainpage");
        }

        if (isset($_SESSION["name"])) {
          $isAdmin = isset($_SESSION["id_access"]) && $_SESSION["id_access"] == 1 ? "<li><a class='dropdown-item' href='/netcar/crud/'>Cadastros</a></li>" : "";
          $icon = isset($_SESSION["id_access"]) && $_SESSION["id_access"] == 1 ? "fa-user-ninja" : "fa-user";
          echo "
          <div class='flex'>
            <a class='navbar-brand shadow-md' href='/netcar/pages/mainpage'>
              <img id='logoHeader' src='/netcar/assets/netcar-ban.png' width='30%'>
            </a>
          </div>
          <div class='flex gap-2 align-items-center'> 
            <span id='timeSession'></span>
            <div class='dropdown dropstart cursor-pointer'>
              <ul class='dropdown-menu dropdown-menu-lg-end dropdown-menu-dark shadow-2'>
                <li><a class='dropdown-item' href='../../components/page_usuario.php'>Perfil</a></li>
                {$isAdmin}
                <li><a class='dropdown-item' id='logout'>Sair</a></li>
              </ul>
              <a class='dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fa-solid {$icon}'></i>
                ". $_SESSION["name"] ."
              </a>
            </div>
          </div>
          ";
        } else {
          echo "
          <div class='flex'>
            <a class='navbar-brand shadow-md' href='../../'>
              <img id='logoHeader' src='../../assets/netcar-ban.png' width='30%'>
            </a>
          </div>
          <div class='flex gap-2 align-items-center'> 
            <a href='../../pages/login/'>Login</a>
            <a href='../../pages/signup/'>Sign up</a>
          </div>
          ";
        }
      ?>
  </nav>
  

<?php 
  if (isset($_SESSION["time"])) {
    echo"
    <script>
    $(document).ready(_ => {
      const logTime = ".$_SESSION['time'].";
      const timer = $('#timeSession')[0];
      const counter = setInterval(() => {
        const currentSec = +(Date.now() / 1000).toString().split('.')[0] - logTime;
        if (timer) {
          timer.innerHTML = '| ' + currentSec +' |';
        }
        if (currentSec > ". $_SESSION["max_time"] .") {
          location.assign(location.origin + '/netcar/utils/expire.php');
          clearInterval(counter);
        }
      }, 555)
    })

    $(document).ready(() => {
      const logout = $('#logout');
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
  </script>
    ";
  }
