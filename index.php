<?php
    session_start();
    if (isset($_GET["cerrarSesion"]))
        session_destroy();

    require "src/features/users/model/Persona.php";
    require "src/features/users/model/Usuario.php";

    $paginasSinSesion = array(
        "src/features/login/views/login.php",
        "src/features/users/views/landing_page.php"
    );
    
    $paginasConSesion = array(
        "src/features/users/views/control_panel.php"
    );
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
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">
    </head>

    <body>
        <?php
            if(!isset($_GET["pdi"])) {
                include "components/navBar.php";
                include "src/features/users/views/landing_page.php";
            } 
            else {
                $pdi = $_GET["pdi"];
                
                if(in_array($pdi, $paginasSinSesion))
                    include ($pdi);

                elseif(in_array($pdi, $paginasConSesion)) {
                    if(isset($_SESSION["id"]))
                        include ($pdi);
                    else
                        include "src/features/login/views/Login.php";
                }
                
                else
                    echo "<h1>Error 404</h1>";
            }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>