<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../../public/assets/css/enviarCorreo.css">
    <title>Cambiar contraseña</title>
</head>

<body>
    <div class="contenido">
        <form autocomplete="off">
            <h1>Cambiar contraseña</h1>

            <input type="password" name="clave" id="clave" placeholder="Contraseña">
            <input type="password" name="claveRepetida" id="claveRepetida" placeholder="Confirmar contraseña">

            <button id="recuperarClave">ENVIAR</button>
        </form>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module" src="../../../../public/assets/js/recuperarClave.js"></script>

</html>