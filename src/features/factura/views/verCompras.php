<?php
    if(!isset($_SESSION['usuario'])) {
        require '../../users/model/Usuario.php';
        session_start();
        $usuario = $_SESSION['usuario'];
    }
?>

<link rel="stylesheet" href="../../../../public/assets/css/factura.css">
<link rel="stylesheet" href="../../../../public/assets/css/productos.css">

<head>
    <title>Ventas</title>
</head>

<div class="productos-contenido">
    <body>
    <div class="container table-container shadow">
        <div class="top-bar">
            <h1>Compras</h1>
        </div>

        <input type="hidden" id="idCliente" name="idCliente" value="<?= $usuario->getIdPersona() ?>">

        <div class="modal fade" id="detalleCompraModal" tabindex="-1" aria-hidden="true">
            <?php include("detalleCompra.php") ?>
        </div>

        <table class="table table-bordered table-striped table-hover display nowrap" id="tablaCompras">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th># Productos</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Info</th>
            </tr>
            </thead>
        </table>
    </div>

    <script src="../../../../public/assets/js/compras.js"></script>
    <script src="../../../../src/lib/HTML2pdf_jsPDF/js/jspdf.debug.js"></script>
    <script src="../../../../src/lib/HTML2pdf_jsPDF/js/html2canvas.min.js"></script>
    <script src="../../../../src/lib/HTML2pdf_jsPDF/js/html2pdf.min.js"></script> 
    </body>
</div>