<link rel="stylesheet" href="../../../../public/assets/css/usuarios.css">
<head>

    <title>Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

</head>
<div class="usuario-contenido">

    <body>

    <div class="container table-container shadow">
        <div class="top-bar">
            <button class="btn btn--small">Registrar Cliente</button>
            <input type="search" class="form-control" placeholder="Buscar...">
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Lead</th>
                <th>Identificación</th>
                <th>País</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Estado</th>
                <th>Ciudad</th>
                <th>Tipo Cliente</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td><button class="btn btn-info text-white"><i class="fas fa-info"></i></button></td>
                <td>12332114</td>
                <td></td>
                <td>carmen</td>
                <td>poveda</td>
                <td></td>
                <td></td>
                <td>Persona Natural</td>
                <td>carpov@outlook.com</td>
                <td>3121286800</td>
                <td class="actions-column">
                    <button class="btn btn-danger"><i class="fas fa-times"></i></button>
                    <button class="btn btn-primary"><i class="fas fa-file-pdf"></i></button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td><button class="btn btn-info text-white"><i class="fas fa-info"></i></button></td>
                <td>1117526300</td>
                <td>Colombia</td>
                <td>CARLOS EDUARDO</td>
                <td>QUINTERO</td>
                <td>Bogotá</td>
                <td>Bogotá</td>
                <td>Persona Natural</td>
                <td></td>
                <td>3103436614</td>
                <td class="actions-column">
                    <button class="btn btn-danger"><i class="fas fa-times"></i></button>
                    <button class="btn btn-primary"><i class="fas fa-file-pdf"></i></button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Paginación -->
        <nav>
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link" href="#">Anterior</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>

    </body>
</div>