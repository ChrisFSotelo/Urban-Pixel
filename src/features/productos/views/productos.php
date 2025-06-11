<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">

<head>
    <title>Productos</title>
</head>

<div class="usuario-contenido">
    <body>
        <div class="container table-container shadow">
            <div class="top-bar">
                <button class="btn btn--small" onclick="abrirModalProducto()">Registrar Producto</button>
                <!-- <input type="search" class="form-control" placeholder="Buscar..."> -->
            </div>

            <div class="modal fade" id="clientesModal" tabindex="-1" aria-hidden="true">
                <?php include("ModalAgregarProductos.php") ?>
            </div>
            <table class="table table-bordered table-striped table-hover display nowrap" id="ablaProductos">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Categoria</th>
                        <th>Lead</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
            </table>
        </div>
<script src="../../../../public/assets/js/productos.js"></script>
    </body>
</div>