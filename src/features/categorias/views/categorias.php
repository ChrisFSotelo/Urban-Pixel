<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">
<link rel="stylesheet" href="../../../../public/assets/css/categorias.css">

<head>
    <title>Categorias</title>
</head>

<div class="categorias-contenido">
    <body>
    <div class="container table-container shadow">
        <div class="top-bar">
            <button class="btn btn--small" onclick="volverAProductos()" title="Vovler a ver productos">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button class="btn btn--small" onclick="abrirModalCategorias()">Registrar categoria</button>
        </div>

        <div class="modal fade" id="categoriasModal" tabindex="-1" aria-hidden="true">
            <?php include("formularioCategorias.php") ?>
        </div>

        <table class="table table-bordered table-striped table-hover display nowrap" id="tablaCategorias">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
            </thead>
        </table>
    </div>

    <script src="../../../../public/assets/js/categorias.js"></script>
    </body>
</div>