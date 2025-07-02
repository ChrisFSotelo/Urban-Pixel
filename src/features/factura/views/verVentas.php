<link rel="stylesheet" href="../../../../public/assets/css/factura.css">
<link rel="stylesheet" href="../../../../public/assets/css/productos.css">

<head>
    <title>Ventas</title>
</head>

<div class="productos-contenido">
    <body>
    <div class="container table-container shadow">
        <div class="top-bar">
            <h1>Ventas</h1>
        </div>

        <div class="modal fade" id="detallesVentaModal" tabindex="-1" aria-hidden="true">
            <?php include("detallesVenta.php") ?>
        </div>

        <table class="table table-bordered table-striped table-hover display nowrap" id="tablaVentas">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th># Productos</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Info</th>
                <th>Eliminar</th>
            </tr>
            </thead>
        </table>
    </div>

    <script src="../../../../public/assets/js/ventas.js"></script>
    </body>
</div>