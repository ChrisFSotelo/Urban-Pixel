// Este archivo se encarga de cambiar el contenido segun la opcion seleccionada en el sidebar

$("#inicioAdmin").click(function() {
    $("#contenido").load("../../inicio/views/inicioAdmin.php");
});

$("#inicioCliente").click(function() {
    $("#contenido").load("../../inicio/views/inicioCliente.php");
});

$("#compras").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de compras
});

$("#productos").click(function() {
    $("#contenido").load("../../productos/views/productos.php");
});

$("#usuarios").click(function() {
    $("#contenido").load("clientes.php");
});

$("#ventas").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de ventas
});

$("#nosotros").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de nosotros
});

$("#contacto").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de contacto
});

function irACategorias() {
    $("#contenido").load("../../categorias/views/categorias.php");
}

function volverAProductos() {
    $("#contenido").load("../../productos/views/productos.php");
}