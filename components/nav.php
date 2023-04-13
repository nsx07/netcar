  <nav class="navbar bg-body-tertiary shadow justify-content-between px-3">
      <?php 
        if (isset($_GET["logout"]) && $_GET["logout"] == 1) {
          $_SESSION = array();

          session_destroy();
          // header("Location: /netcar/pages/mainpage");
        }

        if (isset($_SESSION["name"])) {
          $isAdmin = isset($_SESSION["id_access"]) && $_SESSION["id_access"] == 1 ? "<li><a class='dropdown-item' href='/netcar/pages/cadastros'>Cadastros</a></li>" : "";
          echo "
          <div class='flex'>
            <a class='navbar-brand shadow-md' href='/netcar/pages/mainpage'>
              <img id='logoHeader' src='../../assets/netcar-ban.png' width='30%'>
            </a>
          </div>
          <div class='flex gap-2 align-items-center'> 
            <div class='dropdown'>
            <a class='dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
              <i class='fa-solid fa-user'></i>
              ". $_SESSION["name"] ."
            </a>
            <ul class='dropdown-menu dropdown-menu-lg-end dropdown-menu-dark'>
              <li><a class='dropdown-item' href='#'>Perfil</a></li>
              {$isAdmin}
              <li><a class='dropdown-item' href='#'>Configurações</a></li>
              <li><a class='dropdown-item'  data-bs-toggle='modal' data-bs-target='#staticBackdrop'>Sair</a></li>
            </ul> 
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

  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5 text-center" id="staticBackdropLabel">Deseja sair ?</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="button" id="logout" class="btn btn-danger" style="width: 45%" data-bs-dismiss="modal">Sim</button>
          <button type="button" class="btn btn-success" style="width: 45%" data-bs-dismiss="modal">Não</button>
        </div>
      </div>
    </div>
  </div>


  <script language="javascript">

        <?php 
          if (isset($_SESSION["name"])) {
            echo "
              window.onload = () => {
                document.querySelector('#logout').addEventListener('click', (ev) => {
                  location.assign(location.href + '?logout=1')
                })
              }
          ";
          }
        ?>

  </script>
  
