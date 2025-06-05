    <link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">

    <head>
        <title>Clientes</title>
    </head>

    <div class="usuario-contenido">
        <body>
            <div class="container table-container shadow">
                <div class="top-bar">
                    <button class="btn btn--small" onclick="abirModal()">Registrar Cliente</button>
                    <!-- <input type="search" class="form-control" placeholder="Buscar..."> -->
                </div>

                <div class="modal fade" id="clientesModal" tabindex="-1" aria-hidden="true">
                    <?php include("formulario.php") ?>
                </div>

                <table class="table table-bordered table-striped table-hover display nowrap" id="tablaUsuarios">
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

            <script src="../../../../public/assets/js/cliente.js"></script>
        </body>
    </div>