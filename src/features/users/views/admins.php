<?php
    if(!isset($_SESSION['usuario'])) {
        require '../model/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
    }
?>

<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">

<head>
    <title>Admins</title>
</head>

<div class="usuario-contenido">

    <body>
        <div class="container table-container shadow">
            <div class="top-bar">
                <button class="btn btn--small" onclick="abirModalAdmins()">Registrar Administrador</button>
            </div>

            <div class="modal fade" id="adminsModal" tabindex="-1" aria-hidden="true">
                <?php include("formulario.php") ?>
            </div>

            <input type="hidden" name="idUserAuth" id="idUserAuth" value="<?= $usuario->getIdPersona() ?>">
            
            <table class="table table-bordered table-striped table-hover display nowrap" id="tablaAdmins">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>

        <script src="../../../../public/assets/js/admins.js"></script>
    </body>
</div>