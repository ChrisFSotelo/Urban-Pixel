function abrirModalProducto() {
    document.getElementById("formAgregarProducto").reset();
    document.getElementById("id").value = "";
    $("#tituloModalProducto").text("Agregar Producto");
    $("#submitForm").text("Guardar");
    $(".modal").modal("show");
  }


$("#submitForm").click(function(e){
    e.preventDefault();
    const nombre = document.getElementById("nombre");
    const cantidad = document.getElementById("cantidad");
    const precio = document.getElementById("precio");
    const categoria = document.getElementById("idCategoria");
    const id = document.getElementById("id");

    if(nombre.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese el nombre del producto.",
            icon: "error"
        });
        return false;
    }

    if(cantidad.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese la cantidad.",
            icon: "error"
        });
        return false;
    }

    if(precio.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese el precio del producto.",
            icon: "error"
        });
        return false;
    }

    if(categoria.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese la categoria del producto.",
            icon: "error"
        });
        return false;
    }

    if(id.value === ""){
        guardarNuevoProducto(nombre, cantidad, precio, categoria);
    }
});

async function guardarNuevoProducto(nombre, cantidad, precio, categoria){
    const datos = new FormData();
    datos.append("nombre", nombre.value);
    datos.append("cantidad", cantidad.value);
    datos.append("precio", precio.value);
    datos.append("categoria", categoria.value);

    try {
        const respuesta = await fetch("../controller/ProductoControlador.php?accion=agregar", {
            method: "POST",
            body: datos
        });
        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            $(".modal").modal("hide");
            document.getElementById("formAgregarProducto").reset(); // Asegúrate de usar el ID correcto

            Swal.fire({
                title: "¡Registro exitoso!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaProductos.ajax.reload(); // Recargar la tabla
            });
        } else if(resultado.error) {
            Swal.fire({
                title: "Error",
                text: resultado.error,
                icon: "error"
            });
        }

    } catch (error) {
        console.error("Error al guardar producto:", error);
        Swal.fire({
            title: "Error",
            text: "Ocurrió un error al guardar el producto.",
            icon: "error"
        });
    }
}
