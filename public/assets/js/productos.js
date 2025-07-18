$(document).ready(function() {
    tablaProductos = $("#tablaProductos").DataTable({ // Inicializar DataTable para la tabla de productos

        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        ajax: {
            url: "../../productos/controller/ProductoControlador.php",
            method: "GET",
            dataSrc: "",
            data: {
                accion: "listar"
            },
            error: function(xhr, error, thrown) {
                console.error("XHR response:", xhr.responseText);
            }
        },
        "columns": [
            {"data" : "no"},
            {"data" : "nombre"},
            {"data" : "cantidad"},
            {"data" : "precio"},
            {"data" : "categoria"},
            {
            "data": "estado",
            "render": function(data, type, row){
                let estadoclass= data ==="Activo" ? "estado-activo" : "estado-inactivo"
                let estadoNumerico = data === "Activo" ? 1 : 0;

                return `<button class="estado-btn ${estadoclass}"
                type="button"
                title="Actualizar estado"
                onclick="actualizarEstadoProducto(${row.id}, ${estadoNumerico})">
                ${data}
                </button>
                `
            }
            },
            {"data" : "editar"},
            {"data" : "eliminar"}
        ],
        buttons: [
            {
                extend: "pdfHtml5",
                download: "open",
                titleAttr: "Reporte de Productos (pdf)",
                title: "Reporte de Productos",
                filename: "ReporteProductos",
                text: "<i class='fa-solid fa-file-pdf'></i>",
                className: "pdf btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: "print",
                titleAttr: "Reporte de Productos (imprimir)",
                title: "Reporte de Productos",
                filename: "ReporteProductos",
                text: "<i class='fa-solid fa-print'></i>",
                className: "imprimir btn btn-info",
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            }
        ],
        layout: {
            topStart: 'buttons'
        }
    });
});

function abrirModalProducto() {
    document.getElementById("formAgregarProducto").reset();
    document.getElementById("id").value = "";
    $("#tituloModalProducto").text("Agregar Producto");
    $("#submitForm").text("Guardar");
    cargarCategorias(); 

    $(".modal").modal("show");
}

// Obtiene las categorias
async function cargarCategorias() {
    try {
        const respuesta = await fetch("../../../../src/features/categorias/controller/CategoriaControlador.php?accion=listar");
        const resultado = await respuesta.json();  

        if(resultado && respuesta.error === undefined) {
            const select = document.getElementById("idCategoria");
            select.innerHTML = '<option value="">Seleccione una categoría</option>';

            Array.from(resultado).forEach((cat) => {
                const option = document.createElement("option");
                option.value = cat.id;
                option.textContent = cat.nombre;
                select.appendChild(option);
            });
        } 
        else {
            Swal.fire({
                title: "Error",
                text: resultado.error,
                icon: "error"
            });
        }
    } 
    catch(error) {
        console.error("Error al cargar categorías: ", error);
         Swal.fire({
            title: "Error",
            text: "Ocurrió un error al cargar las categorias.",
            icon: "error"
        });
    }
}

$("#submitForm").click(function(e){
    e.preventDefault();
    const form = document.getElementById("formAgregarProducto");
    const nombre = document.getElementById("nombre");
    const cantidad = document.getElementById("cantidad");
    const precio = document.getElementById("precio");
    const descripcion = document.getElementById("descripcion");
    const categoria = document.getElementById("idCategoria");
    const imagenProducto = document.getElementById("imagenProducto");
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

    if(Number(cantidad.value) < 0){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese una cantidad valida.",
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

    if(Number(precio.value) < 0){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese un precio valido.",
            icon: "error"
        });

        return false;
    }

    if(descripcion.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese una descripción.",
            icon: "error"
        });

        return false;
    }

    if(categoria.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, seleccione la categoria del producto.",
            icon: "error"
        });

        return false;
    }

    if(imagenProducto.value.trim() === "" && id.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, seleccione una imagen para el producto.",
            icon: "error"
        });

        return false;
    }

    if(id.value === "")
        guardarNuevoProducto(nombre, cantidad, precio, descripcion, categoria, imagenProducto);
    else
        editarProducto(form, id, nombre, cantidad, precio, descripcion, categoria, imagenProducto);
});

async function guardarNuevoProducto(nombre, cantidad, precio, descripcion, categoria, imagenProducto) {
    const datos = new FormData();
    datos.append("nombre", nombre.value);
    datos.append("cantidad", cantidad.value);
    datos.append("precio", precio.value);
    datos.append("descripcion", descripcion.value);
    datos.append("categoria", categoria.value);
    datos.append("imagenProducto", imagenProducto.files[0]);

    try {
        const respuesta = await fetch("../../../../src/features/productos/controller/ProductoControlador.php?accion=registrar_producto", {
            method: "POST",
            body: datos
        });
        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            $(".modal").modal("hide");
            document.getElementById("formAgregarProducto").reset(); 

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

    } 
    catch(error) {
        console.error("Error al guardar producto:", error);
        Swal.fire({
            title: "Error",
            text: "Ocurrió un error al guardar el producto.",
            icon: "error"
        });
    }
}

async function obtenerProductoInfo(idProducto) {
    await cargarCategorias();

    try {
        const respuesta = await fetch(`../../../../src/features/productos/controller/ProductoControlador.php?accion=obtenerPorId&id=${idProducto}`);
        const producto = await respuesta.json();

        if(producto && producto.error === undefined) {
            $("#tituloModalProducto").text("Actualizar Producto");
            $("#submitForm").text("Actualizar");
            $(".modal").modal("show");

            // Llenar el formulario con la información del producto
            $("#id").val(producto.id);
            $("#nombre").val(producto.nombre);
            $("#cantidad").val(producto.cantidad);
            $("#precio").val(producto.precio);
            $("#descripcion").val(producto.descripcion);
            document.getElementById("idCategoria").value = producto.idCategoria;
        }
        else {
            Swal.fire({
                title: "Error",
                text: producto.error,
                icon: "error"
            });
        }
    }
    catch(error) {
        console.error("Error al obtener la información del producto: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al obtener la información del producto. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function editarProducto(form, id, nombre, cantidad, precio, descripcion, categoria, imagenProducto) {
    const datos = new FormData();
    datos.append("id", id.value);
    datos.append("nombre", nombre.value);
    datos.append("cantidad", cantidad.value);
    datos.append("precio", precio.value);
    datos.append("descripcion", descripcion.value);
    datos.append("categoria", categoria.value);
    datos.append("imagenProducto", imagenProducto.files[0]);

    try {
        const respuesta = await fetch("../../../../src/features/productos/controller/ProductoControlador.php?accion=actualizar", {
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            $(".modal").modal("hide");
            id.value = ""; // Limpiar el ID
            form.reset(); // Limpiar el formulario

            Swal.fire({
                title: "Actualización exitosa!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaProductos.ajax.reload(); // Recargar la tabla
            });
        }
        else if(resultado.error) {
            Swal.fire({
                title: "Error",
                text: resultado.error,
                icon: "error"
            });
        }
    }
    catch(error) {
        console.error("Error al actualizar: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el producto. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function actualizarEstadoProducto (idProducto, estadoActual){
    const nuevoEstado = estadoActual === 1 ? 0 : 1;
    const textoAccion = nuevoEstado === 1 ? "activar" : "desactivar";

    const confirmacion = await Swal.fire({
        title: `¿Estás seguro?`,
        text: `Estás a punto de ${textoAccion} a este producto.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Cancelar"
    });

    if (!confirmacion.isConfirmed) {
        return; // El usuario canceló
    }

    const datos = new FormData();
    datos.append("id", idProducto);
    datos.append("estado", estadoActual);

    try {
        const respuesta = await fetch("../../../../src/features/productos/controller/ProductoControlador.php?accion=actualizarEstado",{
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();
        if(resultado.mensaje) {
            Swal.fire({
                title: "¡Actualización exitosa!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaProductos.ajax.reload(); // Recargar la tabla
            });
        }
        else if(resultado.error) {
            Swal.fire({
                title: "Error",
                text: resultado.error,
                icon: "error"
            });
        }
    } catch (error) {
        console.error("Error al actualizar el estado del producto hhh: ", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el estado. Intenta nuevamente.",
            icon: "error"
        });
    }
}