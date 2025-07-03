<?php
require 'src/features/users/model/Usuario.php';
session_start();

?>

<!DOCTYPE html>

<html lang="es">

<head>
  <title>Urban Pixel</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="public/assets/css/landing_styles.css" />
  <link rel="stylesheet" href="public/assets/css/general_styles.css" />
  <link rel="stylesheet" href="public/assets/css/products_styles.css" />
</head>

<?php
if (isset($_SESSION["usuario"])) {
  include("components/NavbarConSesion.php");
} else {
  include("components/NavbarSinSesion.php");
}
?>

<main>
  <section class="hero">
    <h2>Descubre nuestra nueva colección</h2>
    <p>Prendas de alta calidad y diseños únicos</p>
  </section>

  <div class="products-wrapper">
    <section class="products" id="carrusel-productos">
    </section>
  </div>
</main>

<?php
include("components/footer.php")
?>

</html>

<script src="public/assets/js/landingPage.js"></script>