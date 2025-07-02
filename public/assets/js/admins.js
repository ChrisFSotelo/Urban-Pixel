$(document).ready(function() {
    const idUserAuth = Number(document.getElementById('idUserAuth').value);
    
    tablaAdmins = $("#tablaAdmins").DataTable({ // Inicializar DataTable para la tabla de clientes
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        ajax: {
            url: "../controller/UsuarioControlador.php",
            method: "GET",
            dataSrc: "",
            data: {
                accion: "listarAdmins",
                idUserAuth: idUserAuth
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
                    onclick="confirmarActualizacionEstadoAdmin(${row.id}, ${estadoNumerico})">
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
                titleAttr: "Reporte de Administradores (pdf)",
                title: "Reporte de Administradores",
                filename: "ReporteAdministradores",
                text: "<i class='fa-solid fa-file-pdf'></i>",
                className: "pdf btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: "print",
                titleAttr: "Reporte de Administradores (imprimir)",
                title: "Reporte de Administradores",
                filename: "ReporteAdministradores",
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

function abirModalAdmins() { // Abrir el modal para agregar un nuevo usuario
    document.getElementById("formulario").reset(); // Limpiar el formulario
    document.getElementById("id").value = ""; // Limpiar el ID
    $(".modal-title").text("Agregar Administrador");
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
        guardarNuevoAdmin(form, nombre, apellido, correo, clave); // Guardar el nuevo admin
    else 
        actualizarAdmin(form, id, nombre, apellido, correo, clave); // Actualizar el cliente admin
});

async function guardarNuevoAdmin(form, nombre, apellido, correo, clave) { // Función para guardar un nuevo admin
    // Construir FormData con los valores
    const datos = new FormData();
    datos.append("nombre", nombre.value);
    datos.append("apellido", apellido.value);
    datos.append("correo", correo.value);
    datos.append("clave", clave.value);

    try {
        const respuesta = await fetch("../controller/UsuarioControlador.php?accion=registrar", {
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
                tablaAdmins.ajax.reload(); // Recargar la tabla
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
            text: "Hubo un problema al registrar el admin. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function obtenerAdminInfo(idAdmin) { // Función para obtener la información del admin por su ID
    try {
        const respuesta = await fetch(`../controller/UsuarioControlador.php?accion=obtenerPorId&id=${idAdmin}`);
        const admin = await respuesta.json();

        if(admin && admin.error === undefined) {
            $(".modal-title").text("Actualizar Administrador");
            $(".submitBtn").text("Actualizar");
            $(".modal").modal("show");

            // Llenar el formulario con la información del admin
            $("#id").val(admin.id);
            $("#nombre-registro").val(admin.nombre);
            $("#apellido-registro").val(admin.apellido);
            $("#correo-registro").val(admin.correo);
            $("#clave-registro").val(admin.clave);
        } 
        else {
            Swal.fire({
                title: "Error",
                text: admin.error,
                icon: "error"
            });
        }
    } 
    catch(error) {
        console.error("Error al obtener la información del admin: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al obtener la información del admin. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function actualizarAdmin(form, id, nombre, apellido, correo, clave) { // Función para actualizar un admin
    // Construir FormData con los valores
    const datos = new FormData();
    datos.append("id", id.value);
    datos.append("nombre", nombre.value);
    datos.append("apellido", apellido.value);
    datos.append("correo", correo.value);
    datos.append("clave", clave.value);

    try {
        const respuesta = await fetch("../controller/UsuarioControlador.php?accion=actualizar", {
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
                tablaAdmins.ajax.reload(); // Recargar la tabla
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
            text: "Hubo un problema al actualizar el admin. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

function confirmarEliminacionAdmin(idAdmin) {
    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás recuperar este administrador una vez eliminado!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar"
    }).then((result) => {
        if(result.isConfirmed)
            eliminarAdmin(idAdmin);
    });
}

async function eliminarAdmin(idAdmin) {
    try {
        const respuesta = await fetch(`../controller/UsuarioControlador.php?accion=eliminar&idAdmin=${idAdmin}`, {
            method: "GET"
        });

        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            Swal.fire({
                title: "Eliminación exitosa!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaAdmins.ajax.reload(); // Recargar la tabla
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
        console.error("Error al eliminar al Adminstrador: ", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al eliminar al Adminstrador. Intenta nuevamente.",
            icon: "error"
        });
    }
}

function confirmarActualizacionEstadoAdmin(idAdmin, estadoActual) {
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
            actualizarEstadoAdmin(idAdmin, estadoActual);
    });
}

async function actualizarEstadoAdmin(idAdmin, estadoActual) {
    const datos = new FormData();
    datos.append("id", idAdmin);
    datos.append("estado", estadoActual);

    try {
        const respuesta = await fetch("../controller/UsuarioControlador.php?accion=actualizarEstado", {
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
                tablaAdmins.ajax.reload(); // Recargar la tabla
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
        console.error("Error al actualizar el estado del admin: ", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el estado. Intenta nuevamente.",
            icon: "error"
        });
    }
}