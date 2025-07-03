$(document).ready(function() {
    tablaVentas = $("#tablaVentas").DataTable({ // Inicializar DataTable para la tabla de productos

        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        ajax: {
            url: "../../factura/controller/FacturaControlador.php",
            method: "GET",
            dataSrc: "",
            data: {
                accion: "listarVentas"
            },
            error: function(xhr, error, thrown) {
                console.error("XHR response:", xhr.responseText);
            }
        },
        "columns": [
            {"data" : "no"},
            {"data" : "cliente"},
            {"data" : "productos"},
            {"data" : "fecha"},
            {"data" : "hora"},
            {
                "data" : "total",
                "render" : (data) => {
                    return `$${Number(data).toLocaleString()}`;
                }
            },
            {
                "data" : "estado",
                "render": (data, type, row) => {
                    const iconoClase = Number(data) === 1 ? 'fa-spinner info'
                        : Number(data) === 2 ? 'fa-circle-check success'
                        : 'fa-ban danger'

                    return `
                        <div class="estado-venta-contenedor">
                            <i class="fa-solid ${iconoClase}"></i>

                            <select id="estado-venta-${row.id}" class="estado-venta">
                                <option value="">Seleccione un estado</option>
                                <option value=1 ${Number(data) === 1 ? 'selected' : ''}>En proceso</option>
                                <option value=2 ${Number(data) === 2 ? 'selected' : ''}>Enviado</option>
                                <option value=3 ${Number(data) === 3 ? 'selected' : ''}>Cancelado</option>
                            </select>
                            <button 
                                class="btn btn-success" 
                                type="button" 
                                title="Actualizar" 
                                onclick="confirmarActualizacionEstadoVenta(${row.id})"
                            >
                                Actualizar
                            </button>
                        </div>
                    `;
                }
            },
            {"data" : "info"},
            {"data" : "eliminar"}
        ],
        buttons: [
            {
                extend: "pdfHtml5",
                download: "open",
                titleAttr: "Reporte de Ventas (pdf)",
                title: "Reporte de Ventas",
                filename: "ReporteVentas",
                text: "<i class='fa-solid fa-file-pdf'></i>",
                className: "pdf btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: "print",
                titleAttr: "Reporte de Ventas (imprimir)",
                title: "Reporte de Ventas",
                filename: "ReporteVentas",
                text: "<i class='fa-solid fa-print'></i>",
                className: "imprimir btn btn-info",
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ],
        layout: {
            topStart: 'buttons'
        }
    });
});

async function obtenerVentaInfo(idVenta) {
    try {
        const respuesta = await fetch(`../../../../src/features/factura/controller/FacturaControlador.php?accion=obtenerDetallesVenta&idVenta=${idVenta}`, {
            method: "GET"
        });

        const venta = await respuesta.json();

        if(venta && venta.error === undefined) {
            document.getElementById("clienteVenta").textContent = venta.cliente;
            document.getElementById("ciudadVenta").textContent = venta.ciudad;
            document.getElementById("direccionVenta").textContent = venta.direccion;
            document.getElementById("fechaVenta").textContent = `${venta.fecha} ${venta.hora}`;

            // Estado con clase visual
            const estadoTexto = {
                "1": "En proceso",
                "2": "Enviado",
                "3": "Cancelado"
            };
            const estadoClase = {
                "1": "en-espera",
                "2": "enviado",
                "3": "cancelado"
            };
            const estadoSpan = document.getElementById("estadoVenta");
            estadoSpan.textContent = estadoTexto[venta.estado] || "Desconocido";
            estadoSpan.className = `estado-tag ${estadoClase[venta.estado]}`;

            // Tabla de productos
            const productos = venta.productos.split(",");
            const cantidades = venta.cantidades.split(",");
            const precios = venta.preciosUnitarios.split(",");
            const totales = venta.precioVentas.split(",");

            const tbody = document.getElementById("productosVenta");
            tbody.innerHTML = "";

            for(let i = 0; i < productos.length; i++) {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${productos[i]}</td>
                    <td>${cantidades[i]}</td>
                    <td>$${Number(precios[i]).toLocaleString()}</td>
                    <td>$${Number(totales[i]).toLocaleString()}</td>
                `;

                tbody.appendChild(tr);
            }

            // Resumen
            const ivaDecimal = parseFloat(venta.iva);
            const ivaValor = Number(venta.subtotal) * ivaDecimal;

            document.getElementById("ivaVentaPorcentaje").textContent = `IVA (${ivaDecimal * 100}%)`;
            document.getElementById("subtotalVenta").textContent = `$${Number(venta.subtotal).toLocaleString()}`;
            document.getElementById("ivaVenta").textContent = `$${ivaValor.toLocaleString(undefined, { maximumFractionDigits: 2 })}`;
            document.getElementById("totalVenta").textContent = `$${Number(venta.total).toLocaleString()}`;

            $(".modal").modal("show");
        }
        else if(venta.error) {
            Swal.fire({
                title: "Error",
                text: venta.error,
                icon: "error"
            });
        }
    } 
    catch (error) {
        console.error("Error al obtener los detalles de la venta: ", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al obtener los detalles. Intenta nuevamente.",
            icon: "error"
        });
    }
}

function confirmarActualizacionEstadoVenta(idVenta) {
    const estadoNuevo = document.getElementById(`estado-venta-${idVenta}`);
    const estadoNuevoTexto = estadoNuevo.options[estadoNuevo.selectedIndex].text;

    if(estadoNuevo.value === ""){
        Swal.fire({
            title: "Error",
            text: "Por favor, seleccione un estado.",
            icon: "error"
        });

        return false;
    }

    Swal.fire({
        title: `¿Estás seguro?`,
        text: `Estás a punto de cambiar el estado a: ${estadoNuevoTexto}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if(result.isConfirmed)
            actualizarEstadoVenta(idVenta, estadoNuevo.value);
    });
}

async function actualizarEstadoVenta(idVenta, estadoNuevo) {
    const form = new FormData();
    form.append('idVenta', idVenta);
    form.append('estadoNuevo', estadoNuevo);

    try {
        const respuesta = await fetch("../../../../src/features/factura/controller/FacturaControlador.php?accion=actualizarEstadoVenta",{
            method: "POST",
            body: form
        });

        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            Swal.fire({
                title: "¡Actualización exitosa!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                tablaVentas.ajax.reload(); // Recargar la tabla
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
    catch (error) {
        console.error("Error al actualizar el estado de la venta: ", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el estado. Intenta nuevamente.",
            icon: "error"
        });
    }
}

function confirmarEliminacionVenta(idVenta) {
    Swal.fire({
        title: `¿Estás seguro?`,
        text: `No podrá recuperar los datos después de la eliminación`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, continuar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if(result.isConfirmed)
            eliminarVentaYDetalles(idVenta);
    });
}

async function eliminarVentaYDetalles(idVenta) {
    try {
        const respuesta = await fetch(`../../../../src/features/factura/controller/FacturaControlador.php?accion=eliminarVenta&id=${idVenta}`,{
            method: "GET"
        });

        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            Swal.fire({
                title: 'Eliminado...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 1500,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                Swal.fire({
                    title: "Eliminación completa",
                    text: resultado.mensaje,
                    icon: "success"
                }).then(() => {
                    tablaVentas.ajax.reload(); // Recargar la tabla
                });
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
    catch (error) {
        console.error("Error al actualizar el estado de la venta: ", error);
        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el estado. Intenta nuevamente.",
            icon: "error"
        });
    }
}