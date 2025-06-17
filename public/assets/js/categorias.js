$(document).ready(function() {
    tablaCategorias = $("#tablaCategorias").DataTable({ // Inicializar DataTable para la tabla de productos
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        ajax: {
            url: "../../categorias/controller/CategoriaControlador.php",
            method: "GET",
            dataSrc: "",
            data: {
                accion: "listar"
            }
        },
        "columns": [
            {"data" : "no"},
            {"data" : "nombre"},
            {"data" : "editar"},
            {"data" : "eliminar"}
        ],
        buttons: [
            {
                extend: "pdfHtml5",
                download: "open",
                titleAttr: "Reporte de Categorias (pdf)",
                title: "Reporte de Categorias",
                filename: "ReporteCategorias",
                text: "<i class='fa-solid fa-file-pdf'></i>",
                className: "pdf btn btn-danger",
                exportOptions: {
                    columns: [0, 1]
                }
            },
            {
                extend: "print",
                titleAttr: "Reporte de Categorias (imprimir)",
                title: "Reporte de Categorias",
                filename: "ReporteCategorias",
                text: "<i class='fa-solid fa-print'></i>",
                className: "imprimir btn btn-info",
                exportOptions: {
                    columns: [0, 1]
                }
            }
        ],
        layout: {
            topStart: 'buttons'
        }
    });
});

function abrirModalCategorias() {
    document.getElementById("formCategorias").reset();
    document.getElementById("id").value = "";
    $("#tituloModal").text("Agregar Categoria");
    $("#submitForm").text("Guardar");
    $(".modal").modal("show");
}

$("#submitForm").click(function(e){
    e.preventDefault();
    const form = document.getElementById("formCategorias");
    const id = document.getElementById("id");
    const nombre = document.getElementById("nombre");

    if(nombre.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese el nombre de la categoria.",
            icon: "error"
        });

        return false;
    }

    if(id.value === "")
        guardarCategoria(nombre);
    else 
        editarCategoria(form, id, nombre);
});

async function guardarCategoria(nombre) {
    const datos = new FormData();
    datos.append("nombre", nombre.value);

    try {
        const respuesta = await fetch("../../categorias/controller/CategoriaControlador.php?accion=agregar", {
            method: "POST",
            body: datos
        });
        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            $(".modal").modal("hide");
            document.getElementById("formCategorias").reset(); 

            Swal.fire({
                title: "¡Registro exitoso!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaCategorias.ajax.reload(); // Recargar la tabla
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
        console.error("Error al guardar categoria: ", error);
        Swal.fire({
            title: "Error",
            text: "Ocurrió un error al guardar la categoria.",
            icon: "error"
        });
    }
}

async function obtenerCategoriaInfo(idCategoria) {
    try {
        const respuesta = await fetch(`../../categorias/controller/CategoriaControlador.php?accion=obtenerPorId&id=${idCategoria}`);
        const categoria = await respuesta.json();

        if(categoria && categoria.error === undefined) {
            $("#tituloModal").text("Actualizar Categoria");
            $("#submitForm").text("Actualizar");
            $(".modal").modal("show");

            // Llenar el formulario con la información de la categoria
            $("#id").val(categoria.id);
            $("#nombre").val(categoria.nombre);
        } 
        else if(categoria.error) {
            Swal.fire({
                title: "Error",
                text: categoria.error,
                icon: "error"
            });
        }
    } 
    catch(error) {
        console.error("Error al obtener la información de la categoria: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al obtener la información de la categoria. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function editarCategoria(form, id, nombre) {
    const datos = new FormData();
    datos.append("id", id.value);
    datos.append("nombre", nombre.value);

    try {
        const respuesta = await fetch("../../categorias/controller/CategoriaControlador.php?accion=actualizar", {
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
                tablaCategorias.ajax.reload(); // Recargar la tabla
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
        console.error("Error al actualizar categoria: ", error);
        Swal.fire({
            title: "Error",
            text: "Ocurrió un error al actualizar la categoria.",
            icon: "error"
        });
    }
}

function confirmarEliminacion(idCategoria) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás recuperar esta categoría una vez eliminada!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar"
    }).then((result) => {
        if(result.isConfirmed)
            eliminarCategoria(idCategoria);
    });
}

async function eliminarCategoria(idCategoria) {
    try {
        const respuesta = await fetch(`../../categorias/controller/CategoriaControlador.php?accion=eliminar&id=${idCategoria}`);
        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            Swal.fire({
                title: "Eliminacion exitosa!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaCategorias.ajax.reload(); // Recargar la tabla
            });
        } 
        else if(resultado.error){
            Swal.fire({
                title: "Error",
                text: resultado.error,
                icon: "error"
            });
        }
    } 
    catch (error) {
        console.error("Error al eliminar categoria: ", error);
        Swal.fire({
            title: "Error",
            text: "Ocurrió un error al eliminar la categoria.",
            icon: "error"
        });
    }
}