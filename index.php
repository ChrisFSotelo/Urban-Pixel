<?php 
  require_once "src/features/users/model/Usuario.php";
  require_once "src/features/roles/model/Rol.php";
  session_start();
  
  if(isset($_SESSION["usuario"])) {
    if(($_SESSION["usuario"])->getRol()->getNombre() === "Administrador") {
      header("Location: src/features/users/views/control_panel.php");
      exit;
    }
    if(($_SESSION["usuario"])->getRol()->getNombre() === "Cliente") {
      // Vista cliente
      exit;
    }
  }
  else {
?>

<!DOCTYPE html>

<html lang="es">
  <head>
    <title>Urban Pixel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/css/landing_styles.css" />
    <link rel="stylesheet" href="public/assets/css/general_styles.css" />
  </head>

  <body>
    <?php 
      include("components/navBar.php")
    ?>

    <main>
      <section class="hero">
        <h2>Descubre nuestra nueva colección</h2>
        <p>Prendas de alta calidad y diseños únicos</p>
      </section>

      <section class="products">
        <div class="product">
          <img src="https://via.placeholder.com/250x300" alt="Producto 1" />
          <h3>Camisa Clásica</h3>
          <p>Algodón premium - Tallas S a XL</p>
          <button>Comprar</button>
        </div>
        <div class="product">
          <img src="https://via.placeholder.com/250x300" alt="Producto 2" />
          <h3>Sudadera Urbana</h3>
          <p>Comodidad para tu día a día</p>
          <button>Comprar</button>
        </div>
        <div class="product">
          <img src="https://via.placeholder.com/250x300" alt="Producto 3" />
          <h3>Gorra Bordada</h3>
          <p>Diseño exclusivo Urban Pixel</p>
          <button>Comprar</button>
        </div>
      </section>
    </main>

    <?php 
      include("components/footer.php")
    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>

<?php } ?>