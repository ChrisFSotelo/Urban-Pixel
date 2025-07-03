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
            <i class="fas fa-users icon"></i>
            <h3>Usuarios</h3>
            <p>Gestiona los usuarios del sistema.</p>
            <span onclick="irAUsuariosDesdeDashboard()">Entrar</span>
        </div>

        <div class="card">
            <i class="fas fa-box icon"></i>
            <h3>Productos</h3>
            <p>Administra el catálogo de productos.</p>
            <span onclick="irAProductosDesdeDashboard()">Entrar</span>
        </div>

        <div class="card">
            <i class="fas fa-chart-line icon"></i>
            <h3>Ventas</h3>
            <p>Consulta los reportes de ventas.</p>
            <span onclick="irAVentasDesdeDashboard()">Entrar</span>
        </div>

        <div class="card">
            <i class="fas fa-user-plus icon"></i>
            <h3>Agregar Admin</h3>
            <p>Crea nuevas cuentas administrativas.</p>
            <span onclick="irAAdministradores()">Entrar</span>
        </div>

        <div class="card highlight">
            <i class="fas fa-user-cog icon"></i>
            <h3>Editar Perfil</h3>
            <p>Actualiza tu información personal.</p>
            <span onclick=irAPerfil()>Entrar</span>
        </div>
    </div>
</div>