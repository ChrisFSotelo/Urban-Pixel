<?php
    if(!isset($_SESSION['usuario'])) {
        require '../model/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
    }
?>

<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">
<link rel="stylesheet" href="../../../../public/assets/css/perfil.css">

<div class="perfil-container">
    <h2>Editar Perfil</h2>
    
    <form id="perfilForm" class="perfil-form" autocomplete="off">
        <input type="hidden" id="id" name="id" value="<?= $usuario->getIdPersona() ?>">
        <input type="hidden" id="idRol" name="idRol" value="<?= $usuario->getRol() ?>">

        <div class="input-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?= $usuario->getNombre() ?>">
        </div>

        <div class="input-group">
            <label for="apellido">Apellido</label>
            <input type="text" id="apellido" name="apellido" placeholder="Apellido" value="<?= $usuario->getApellido() ?>">
        </div>

        <div class="input-group">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" placeholder="Correo" value="<?= $usuario->getCorreo() ?>">
        </div>

        <div class="input-group password-group">
            <label for="contrasena">Contraseña</label>
            <div class="password-wrapper">
                <input type="password" id="clave" name="clave" placeholder="Contraseña">
                <button type="button" id="togglePassword">
                    <i id="eye-icon" class="fa-solid fa-eye"></i>
                </button>
            </div>
        </div>

        <button type="button" class="submit-btn-profile" id="submit-btn-profile">Actualizar Perfil</button>
    </form>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", () => {
        const pass = document.getElementById("clave");
        const icon = document.getElementById('eye-icon');

        pass.type = pass.type === "password" ? "text" : "password";
        icon.classList = pass.type === 'password' ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye';
    });
</script>
<script src="../../../../public/assets/js/actualizarPerfil.js"></script>
