// Este archivo se encarga de cambiar el contenido segun la opcion seleccionada en el sidebar

$("#inicio").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de inicio
});

$("#productos").click(function() {
    $("#contenido").load("../../productos/views/productos.php");
});

$("#usuarios").click(function() {
    $("#contenido").load("clientes.php");
});

$("#ventas").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de nosotros
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