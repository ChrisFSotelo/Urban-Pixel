// Este archivo se encarga de cambiar el contenido segun la opcion seleccionada en el sidebar

$("#inicioAdmin").click(function() {
    $("#contenido").load("../../inicio/views/inicioAdmin.php");
});

$("#inicioCliente").click(function() {
    $("#contenido").load("../../inicio/views/inicioCliente.php");
});

$("#compras").click(function() {
    $("#contenido").load('../../factura/views/verCompras.php');
});

$("#productos").click(function() {
    $("#contenido").load("../../productos/views/productos.php");
});

$("#usuarios").click(function() {
    $("#contenido").load("clientes.php");
});

$("#ventas").click(function() {
    $("#contenido").load('../../factura/views/verVentas.php');
});

$("#perfil").click(function() {
    $("#contenido").load('perfil.php');
});

$("#nosotros").click(function() {
    $("#contenido").load("../../inicio/views/nosotros.php");
});

$("#contacto").click(function() {
    $("#contenido").load("../../inicio/views/contacto.php");
});

function irAUsuariosDesdeDashboard() {
    sombrearSidebar('usuarios');
    $("#contenido").load("clientes.php");
}

function irAComprasDesdeDashboard() {
    sombrearSidebar('compras');
    $("#contenido").load("../../factura/views/verCompras.php");
}

function irAProductosDesdeDashboard() {
    sombrearSidebar('productos');
    $("#contenido").load("../../productos/views/productos.php");
}

function irAVentasDesdeDashboard() {
    sombrearSidebar('ventas');
    $("#contenido").load('../../factura/views/verVentas.php');
}

function irANosotrosDesdeDashboard() {
    sombrearSidebar('nosotros');
    $("#contenido").load("../../inicio/views/nosotros.php");
}

function irAContactanosDesdeDashboard() {
    sombrearSidebar('contacto');
    $("#contenido").load("../../inicio/views/contacto.php");
}

function irAPerfil() {
    sombrearSidebar('perfil');
    $("#contenido").load('perfil.php');
}


function irAAdministradores() {
    sombrearSidebar('inicioAdmin');
    $("#contenido").load('admins.php');
}

function irACategorias() {
    $("#contenido").load("../../categorias/views/categorias.php");
}

function volverAProductos() {
    $("#contenido").load("../../productos/views/productos.php");
}

function sombrearSidebar(opcion) {
    const options = document.querySelectorAll('.optionToSelect');
    options.forEach(opt => opt.classList.remove('active'));
    document.getElementById(opcion).classList.add('active');
}