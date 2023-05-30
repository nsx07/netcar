<nav class="navbar bg-body-tertiary shadow justify-content-between px-3">
    <?php 
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
              <li><a class='dropdown-item' href='#'>Perfil</a></li>
              {$isAdmin}
              <li><a class='dropdown-item' href='#'data-bs-toggle='offcanvas' data-bs-target='#offcanvasRight' aria-controls='offcanvasRight'>Configurações</a></li>
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
  
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Configurações</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="profile-pic">
        <img src="/netcar/assets/ícone.png" alt="Foto de Perfil" width="200" height="200">

    </div>
  </div>
</div>
