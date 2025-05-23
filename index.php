<?php
/* 
    Import del archivo routes.php para obtener
    las rutas de las vistas de la aplicación
*/

$routes = require(__DIR__ . "/config/routes.php");
$currentPath = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$requiresSession = $routes[$currentPath]['requires_session'] ?? false;
$allowedRoles = $routes[$currentPath]['allowed_roles'] ?? [];
$viewPath = $routes[$currentPath]['view'] ?? null;

// session_start();
// if (isset($_GET["cerrarSesion"])) {
//     session_destroy();
// }


// require "src/feactures/users/models/Persona.php";
// require "src/feactures/users/models/Usuario.php";

// $paginasSinSesion = array(
//     "src/feactures/login/views/login.php",
//     "src/feactures/users/views/landing_page.php"
// );
// $paginasConSesion = array(
//     "src/feactures/users/views/control_panel.html "
// );

if (!$viewPath || !file_exists(__DIR__ . '/' . $viewPath)) {
    http_response_code(500);
    echo "Error interno: La vista asociada no existe.";
    exit;
}
?>

<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Urban Pixel</title>
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
    <header>
        <?php include "components/navBar.php"; ?>
    </header>
    <main>
        <?php include __DIR__ . "/" . $viewPath; ?>
    </main>

    <?php
    /*
    if (!isset($_GET["pdi"])) {
        include "components/navBar.php";
        include "src/feactures/users/views/landing_page.php";

    } else {
        $pdi = base64_decode($_GET["pdi"]);
        if (in_array($pdi, $paginasSinSesion)) {
            include ($pdi);
        } elseif (in_array($pdi, $paginasConSesion)) {
            if (isset($_SESSION["id"])) {
                include ($pdi);
            } else {
                include "src/feactures/login/views/Login.php";
            }
        }else{
            echo "<h1>Error 404</h1>";
        }
    }*/
    ?>
</body>
<footer>
    <?php include "components/footer.php"; ?>
</footer>

</html>