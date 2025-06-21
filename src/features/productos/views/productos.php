<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">
<link rel="stylesheet" href="../../../../public/assets/css/productos.css">

<head>
    <title>Productos</title>
</head>

<div class="productos-contenido">
    <body>
    <div class="container table-container shadow">
        <div class="top-bar">
            <button class="btn btn--small" onclick="abrirModalProducto()">Registrar Producto</button>
            <button class="btn btn--small" onclick="irACategorias()">Ver Categorias</button>
            <!-- <input type="search" class="form-control" placeholder="Buscar..."> -->
        </div>

        <div class="modal fade" id="productoModal" tabindex="-1" aria-hidden="true">
            <?php include("ModalAgregarProductos.php") ?>
        </div>

        <table class="table table-bordered table-striped table-hover display nowrap" id="tablaProductos">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Categoria</th>
                <th>Estado</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            </thead>
        </table>
    </div>

    <script src="../../../../public/assets/js/productos.js"></script>
    </body>
</div>