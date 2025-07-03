<?php
    if(!isset($_SESSION['usuario'])) {
        require '../../users/model/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
    }
?>

<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">
<link rel="stylesheet" href="../../../../public/assets/css/inicioAdmin.css">

<head>
    <title>Inicio</title>
</head>

<div class="dashboard">
    <h2 class="welcome-title">¡Bienvenido, <?php echo $usuario->getNombre() ?></h2>

    <div class="dashboard-cards">
        <div class="card">
            <i class="fas fa-chart-line icon"></i>
            <h3>Compras</h3>
            <p>Consulta tus compras realizadas.</p>
            <span onclick="irAComprasDesdeDashboard()">Entrar</span>
        </div>

        <div class="card">
            <i class="fas fa-building icon"></i>
            <h3>Sobre nosotros</h3>
            <p>Conoce más sobre Urban Pixel.</p>
            <span onclick="irANosotrosDesdeDashboard()">Entrar</span>
        </div>

        <div class="card">
            <i class="fas fa-envelope icon"></i>
            <h3>Contactanos</h3>
            <p>Comentanos tus dudas o sugerencias.</p>
            <span onclick="irAContactanosDesdeDashboard()">Entrar</span>
        </div>

        <div class="card highlight">
            <i class="fas fa-user-cog icon"></i>
            <h3>Editar Perfil</h3>
            <p>Actualiza tu información personal.</p>
            <span onclick=irAPerfil()>Entrar</span>
        </div>
    </div>
</div>