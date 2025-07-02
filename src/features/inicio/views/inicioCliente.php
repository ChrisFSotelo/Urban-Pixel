<?php
    if(!isset($_SESSION['usuario'])) {
        require '../../users/model/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
    }
?>

<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">

<head>
    <title>Inicio</title>
</head>

<div class="usuario-contenido">
    <body>
        <div class="container table-container shadow">
            <h1>Inicio Cliente -> <?php echo $usuario->getNombre() ?></h1>
            <p>Insertar productos aquí :)</p>
        </div>
    </body>
</div>