<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@master/dist/latest/bootstrap-autocomplete.min.js"></script>
  <script src="https://kit.fontawesome.com/54b6e9ecc9.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.js"></script>

  <script src="/netcar/utils/profiler.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.7.1/slick-theme.css">
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
    const WWWROOTPATH = "/netcar/wwwroot/";

    function load(state) {
      if (state) {
        $('#loader').fadeIn('slow');
      } else {
        $('#loader').fadeOut('slow');
      }
    }
    
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

      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
  
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

    $(window).on('load', function() {
      $('#loader').fadeOut('slow');
      $('#conteudo').fadeIn('slow');
    });

  </script>

<?php
  } 
?>