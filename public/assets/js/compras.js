$(document).ready(function() {
    const idCliente = document.getElementById('idCliente').value;

    tablaCompras = $("#tablaCompras").DataTable({ // Inicializar DataTable para la tabla de productos
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
                accion: "listarCompras",
                idCliente: idCliente
            },
            error: function(xhr, error, thrown) {
                console.error("XHR response:", xhr.responseText);
            }
        },
        "columns": [
            {"data" : "no"},
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
                "render" : (data) => {
                    const estadoClase = {
                        "1": "en-espera",
                        "2": "enviado",
                        "3": "cancelado"
                    };

                    const estadoIcono = {
                        "1": "fa-solid fa-spinner",
                        "2": "fa-solid fa-circle-check",
                        "3": "fa-solid fa-ban"
                    };

                    const estadoTexto = {
                        "1": "En proceso",
                        "2": "Enviado",
                        "3": "Cancelado"
                    };

                    return `
                        <div class="estado-tag ${estadoClase[data]}">
                            <i class="${estadoIcono[data]}"></i>
                            <span>${estadoTexto[data]}</span>
                        </div>
                    `;
                }
            },
            {"data" : "info"}
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

async function obtenerCompraInfo(idCompra) {
    try {
        const respuesta = await fetch(`../../../../src/features/factura/controller/FacturaControlador.php?accion=obtenerDetallesVenta&idVenta=${idCompra}`, {
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

function imprimirReciboCompra() {
    const idCliente = document.getElementById("idCliente").value;
    const clienteNombre = document.getElementById("clienteVenta").textContent;
    const fechaCompra = document.getElementById("fechaVenta").textContent;
    const reciboCompra = document.getElementById('recibo-compra');

    const pdfConfig = {
        margin: 0.5,
        filename: `${idCliente}_${clienteNombre}_${fechaCompra}.pdf`,
        html2canvas: {
            scale: 1
        },
        jsPDF: {
            unit: 'in',
            format: 'letter',
            orientation: 'portrait'
        }
    };

    html2pdf().from(reciboCompra).set(pdfConfig).save();
}