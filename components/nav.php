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
              <li><a class='dropdown-item' id='logout'>Sair</a></li>
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

  
