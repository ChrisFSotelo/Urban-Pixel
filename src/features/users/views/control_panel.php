<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - Administrador</title>
  <link rel="stylesheet" href="../../../../public/assets/css/general_styles.css">
  <link rel="stylesheet" href="../../../../public/assets/css/control_panel.css">
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
      </div>
    </section>
  </main>

  <?php include "../../../../components/footer.php"; ?>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" 
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" 
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="../../../../public/assets/js/cambiarContenido.js"></script>
</body>