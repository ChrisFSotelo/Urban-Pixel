$(document).ready(function() {
    tablaUsuarios = $("#tablaUsuarios").DataTable({ // Inicializar DataTable para la tabla de clientes
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        ajax: {
            url: "../controller/ClienteControlador.php",
            method: "GET",
            dataSrc: "",
            data: {
                accion: "listar"
            }
        },
        "columns": [
            {"data" : "no"},
            {"data" : "nombre"},
            {"data" : "apellido"},
            {"data" : "correo"},
            {
                "data": "idEstado",
                "render": function(data, type, row) {
                    let estadoClass = data === "Activo" ? "estado-activo" : "estado-inactivo";
                    let estadoNumerico = data === "Activo" ? 1 : 0;

                    return `<button class="estado-btn ${estadoClass}" 
                    type="button" 
                    title="Actualizar estado" 
                    onclick="confirmarActualizacionEstadoCliente(${row.id}, ${estadoNumerico})">
                ${data}
            </button>`;
                }

            },
            {"data" : "editar"},
            {"data" : "eliminar"},
        ],
        buttons: [
            {
                extend: "pdfHtml5",
                download: "open",
                titleAttr: "Reporte de Usuarios (pdf)",
                title: "Reporte de Usuarios",
                filename: "ReporteUsuarios",
                text: "<i class='fa-solid fa-file-pdf'></i>",
                className: "pdf btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: "print",
                titleAttr: "Reporte de Usuarios (imprimir)",
                title: "Reporte de Usuarios",
                filename: "ReporteUsuarios",
                text: "<i class='fa-solid fa-print'></i>",
                className: "imprimir btn btn-info",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ],
        layout: {
            topStart: 'buttons'
        }
    });
});

function abirModal() { // Abrir el modal para agregar un nuevo usuario
    document.getElementById("formulario").reset(); // Limpiar el formulario
    document.getElementById("id").value = ""; // Limpiar el ID
    $(".modal-title").text("Agregar Cliente");
    $(".submitBtn").text("Guardar");
    $(".modal").modal("show");
}
 
$("#submitForm").click(function(e) { // Evento para el botón de enviar del formulario
    e.preventDefault();
    const correoRegex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    const id = document.getElementById("id");
    const nombre = document.getElementById("nombre-registro");
    const apellido = document.getElementById("apellido-registro");
    const correo = document.getElementById("correo-registro");
    const clave = document.getElementById("clave-registro");
    const form = document.getElementById("formulario");

    if(nombre.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese un nombre.",
            icon: "error"
        });

        return false;
    }

    if(apellido.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese un apellido.",
            icon: "error"
        });

        return false;
    }

    if(correo.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese un correo.",
            icon: "error"
        });

        return false;
    }

    if(!correoRegex.test(correo.value)){
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese un correo valido.",
            icon: "error"
        });

        return false;
    }

    if(clave.value === "" && id.value === "") { // Si la clave está vacía y no se está actualizando un cliente
        Swal.fire({
            title: "Error",
            text: "Por favor, ingrese una clave.",
            icon: "error"
        });

        return false;
    }

    if(id.value === "") // Si el ID está vacío, agrega al cliente
        guardarNuevoCliente(form, nombre, apellido, correo, clave); // Guardar el nuevo cliente
    else 
        actualizarCliente(form, id, nombre, apellido, correo, clave); // Actualizar el cliente existente
});

async function guardarNuevoCliente(form, nombre, apellido, correo, clave) { // Función para guardar un nuevo cliente
    // Construir FormData con los valores
    const datos = new FormData();
    datos.append("nombre", nombre.value);
    datos.append("apellido", apellido.value);
    datos.append("correo", correo.value);
    datos.append("clave", clave.value);

    try {
        const respuesta = await fetch("../controller/ClienteControlador.php?accion=registrar", {
            method: "POST",
            body: datos
        });

        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            $(".modal").modal("hide");
            form.reset(); // Limpiar el formulario

            Swal.fire({
                title: "¡Registro exitoso!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaUsuarios.ajax.reload(); // Recargar la tabla
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
        console.error("Error al registrar: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al registrar el cliente. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function obtenerClienteInfo(idCliente) { // Función para obtener la información del cliente por su ID
    try {
        const respuesta = await fetch(`../controller/ClienteControlador.php?accion=obtenerPorId&id=${idCliente}`);
        const cliente = await respuesta.json();

        if(cliente && cliente.error === undefined) {
            $(".modal-title").text("Actualizar Cliente");
            $(".submitBtn").text("Actualizar");
            $(".modal").modal("show");

            // Llenar el formulario con la información del cliente
            $("#id").val(cliente.id);
            $("#nombre-registro").val(cliente.nombre);
            $("#apellido-registro").val(cliente.apellido);
            $("#correo-registro").val(cliente.correo);
            $("#clave-registro").val(cliente.clave);
        } 
        else {
            Swal.fire({
                title: "Error",
                text: cliente.error,
                icon: "error"
            });
        }
    } 
    catch(error) {
        console.error("Error al obtener la información del cliente: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al obtener la información del cliente. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function actualizarCliente(form, id, nombre, apellido, correo, clave) { // Función para actualizar un cliente
    // Construir FormData con los valores
    const datos = new FormData();
    datos.append("id", id.value);
    datos.append("nombre", nombre.value);
    datos.append("apellido", apellido.value);
    datos.append("correo", correo.value);
    datos.append("clave", clave.value);

    try {
        const respuesta = await fetch("../controller/ClienteControlador.php?accion=actualizar", {
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
                tablaUsuarios.ajax.reload(); // Recargar la tabla
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
            text: "Hubo un problema al actualizar el cliente. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

function confirmarEliminacion(idCliente) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás recuperar este cliente una vez eliminado!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar"
    }).then((result) => {
        if(result.isConfirmed)
            eliminarCliente(idCliente);
    });
}

function eliminarCliente(idCliente) {
    console.log("Eliminando cliente con ID:", idCliente);
}

function confirmarActualizacionEstadoCliente(idCliente, estadoActual) {
    const textoAccion = estadoActual === 1 ? "desactivar" : "activar";

    Swal.fire({
        title: "¿Estás seguro?",
        text: `Estás a punto de ${textoAccion} al  este cliente.`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, continuar"
    }).then((result) => {
        if(result.isConfirmed)
            actualizarEstadoCliente(idCliente, estadoActual);
    });
}

async function actualizarEstadoCliente(idCliente, estadoActual) {
    const datos = new FormData();
    datos.append("id", idCliente);
    datos.append("estado", estadoActual);

    try {
        const respuesta = await fetch("../controller/ClienteControlador.php?accion=actualizarEstado", {
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
                tablaUsuarios.ajax.reload(); // Recargar la tabla
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
        console.error("Error al actualizar el estado del cliente: ", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el estado. Intenta nuevamente.",
            icon: "error"
        });
    }
}