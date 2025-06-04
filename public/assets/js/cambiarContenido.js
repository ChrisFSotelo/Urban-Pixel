// Este archivo se encarga de cambiar el contenido segun la opcion seleccionada en el sidebar

$("#inicio").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de inicio
});

$("#productos").click(function() {
    $("#contenido").load("../../productos/views/productos.php"); // El archivo productos.php aún no existe
});

$("#usuarios").click(function() {
    $("#contenido").load("clientes.php");
});

$("#nosotros").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de nosotros
});

$("#contacto").click(function() {
    $("#contenido").load(); // Completar con la ruta del contenido de contacto
});