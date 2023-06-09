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
              {$isAdmin}
              <li><a class='dropdown-item' id='profile' data-bs-toggle='offcanvas' data-bs-target='#offcanvasRight' aria-controls='offcanvasRight'>Perfil</a></li>
              <li><a class='dropdown-item' id='logout'>Sair</a></li>
            </ul>
            <a class='dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
              <i class='fa-solid {$icon}'></i>
              ". $_SESSION["name"] ."
            </a>
          </div>
        </div>

    <div class='offcanvas offcanvas-start' tabindex='-1' id='offcanvasRight' aria-labelledby='offcanvasRightLabel'>
      <div class='offcanvas-header'>
        <h5 class='offcanvas-title' id='offcanvasRightLabel'> Perfil </h5>
        <button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
      </div>
    
      <div class='offcanvas-body'>
        <div class='profile-pic'>
            <input type='file' id='userInput' name='image' accept='image/*'>
            <div class='dropdown'>
              <a type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                <div id='userPreview' class='image-profile'></div>
              </a>
              <ul class='dropdown-menu'>
                <li><a class='dropdown-item cursor-pointer' onclick='editUserImage()'>Alterar imagem <i class='ml fa-solid fa-user-pen'></i></a></li>
                <li><a class='dropdown-item cursor-pointer' onclick='deleteUserImage()' >Excluir imagem <i class='ml fa-solid fa-trash'></i></a></li>
              </ul>
            </div>
        </div>
        <form id='formProfile'>
          <div class='grid p-2 my-3'>
            <div class='col-12 py-2 text-center'>
                <h2 id='nameProfile'> </h2>
                <h5>Altere seus dados aqui</h5>
            </div>
            <div class='col-12 mt-2'>
                <label for='emailProfile'>Email</label>
                <input autocomplete='name' type='text' class='form-control' id='emailProfile' name='email' placeholder='Ex: customer@netcar.com.br' required>
                <small class='feedbackemailprofile fs-6 text text-danger'></small>
            </div>
            <div class='col-12 mt-2'>
                <label for='phoneProfile'>Telefone</label>
                <input autocomplete='name' type='text' class='form-control' id='phoneProfile' name='phone' maxlength='15' placeholder='Ex: (DD) 9 9999-9999' required>
                <small class='feedbackphoneprofile fs-6 text text-danger'></small>
            </div>
            <div class='col-12 mt-2'>
                <button class='btn btn-lg bg-default text-white' id='saveProfile' type='button' disabled>
                  <span id='default'>
                    Salvar
                  </span> 
                </button>
            </div>
          </div
        </form>
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