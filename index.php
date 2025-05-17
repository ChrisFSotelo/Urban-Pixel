<?php
session_start();
if (isset($_GET["cerrarSesion"])) {
    session_destroy();
}
// Rutas absolutas desde la raíz del proyecto
define('BASE_PATH', __DIR__);                       // c:/xampp/htdocs/Urban-Pixel
define('CONFIG_PATH', BASE_PATH . '/config');       // .../config
define('FEATURES_PATH', BASE_PATH . './src/features');// .../src/features

require_once FEATURES_PATH . "users/models/Persona.php";


$paginasSinSesion = array(
    FEATURES_PATH . "login/views/login.php",
    FEATURES_PATH . "login/views/Home.php"
);
$paginasConSesion = array(
    FEATURES_PATH . "users/views/perfil.php"
);
?>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Urban Pixel</title>
    <link rel="stylesheet" href="../../../../public/assets/css/styles.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- TIPOGRAFIA -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />
</head>

<body>
    <?php
    if (!isset($_GET["pdi"])) {
        include feactures . "login/views/Home.php";
    } else {
        $pdi = base64_decode($_GET["pdi"]);
        if (in_array($pdi, $paginasSinSesion)) {
            include $pdi;
        } elseif (in_array($pdi, $paginasConSesion)) {
            if (isset($_SESSION["id"])) {
                include $pdi;
            } else {
                echo "<h1>Error 404</h1>";
            }
        }
    }
    ?>
</body>

</html>