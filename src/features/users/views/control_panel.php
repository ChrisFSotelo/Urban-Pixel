<?php 
  require_once "../../users/model/Usuario.php";
  require_once "../../roles/model/Rol.php";
  session_start();

  if(!isset($_SESSION["usuario"])) {
    session_unset();
    session_destroy();
    header("Location: ../../../../");
    exit;
  }
  else if(($_SESSION["usuario"])->getRol()->getNombre() === "Cliente") {
    // Redirigir a la vista de cliente
    exit;
  }
  else {
?>

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../../public/assets/css/general_styles.css">
    <link rel="stylesheet" href="../../../../public/assets/css/control_panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/datatables.min.css" 
      rel="stylesheet" integrity="sha384-i/NY1sv/bRb2pkJM6qD8wiQ/CpmhXGnwFOEg9zWjjEICnl6uaspfL6PWt8cAYmNk" 
      crossorigin="anonymous">
    <title>Inicio - Administrador</title>
  </head>

  <body>
    <header>
      <h2>Bienvenido/a al panel Administrativo</h2>
    </header>

    <main>
      <section>
        <div class="sidebar">
          <?php include "../../../../components/sideBar.php"; ?>
        </div>

        <div class="content" id="contenido">
          <?php include("../../inicio/views/inicio.php") ?> <!-- Ventana de inicio abierta al cargar la página -->
        </div>
      </section>
    </main>

    <?php include "../../../../components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
      integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" 
      integrity="sha384-VFQrHzqBh5qiJIU0uGU5CIW3+OWpdGGJM9LBnGbuIH2mkICcFZ7lPd/AAtI7SNf7" 
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" 
      integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" 
      crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/r-3.0.4/datatables.min.js" 
      integrity="sha384-Ww2PfGxKNewKZTOBui3hCUBhkjTHc2rDy5cWQYyF7vGD7IL4dQr2QnZGxgEE5gvb" 
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../../../public/assets/js/cambiarContenido.js"></script>
  </body>

<?php } ?>