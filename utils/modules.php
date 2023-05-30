<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@master/dist/latest/bootstrap-autocomplete.min.js"></script>
    <script src="https://kit.fontawesome.com/54b6e9ecc9.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/jquery-tags-input/dist/jquery.tagsinput.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="/netcar/style.css">
  </head>

  <?php 
    session_start();

    if (isset($_GET["logout"]) || (isset($_SESSION["time"]) && time() - $_SESSION["time"] > $_SESSION["max_time"]) ) {
      $_SESSION = array();
      session_destroy();
      header("Location: /netcar/pages/mainpage");
    }

    if (isset($_SESSION["time"])) {
  ?>
    <script language='javascript'>
      $(document).ready(_ => {
        const logTime = <?php echo $_SESSION['time'];?>;
        const maxTime = <?php echo $_SESSION['max_time'];?>;
        const timer = $('#timeSession')[0];

        const counter = setInterval(() => {
          const currentSec = +(Date.now() / 1000).toString().split('.')[0] - logTime;
          if (timer) {
            timer.innerHTML = '| ' + currentSec +' |';
          }
          if (currentSec > maxTime) {
            location.assign(location.origin + '/netcar/utils/expire.php');
            clearInterval(counter);
          }
        }, 555)

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
              });
                
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
              });
            })
        }
      })
  

    </script>
  <?php
    } 
  ?>

  <script>
    $(window).on('load', function() {
      $('#loader').fadeOut('slow');
      $('#conteudo').fadeIn('slow');
    });

    $(document).ready(() => {
      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    })

    const WWWROOTPATH = "/netcar/wwwroot/";


  </script>
  