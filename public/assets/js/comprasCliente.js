//console.log("compras")
$(document).ready(function () {
    tablaCompras = $("#tablaCompras").DataTable({ // Inicializar DataTable para la tabla de productos

        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        ajax: {
            url: "../../producto_factura/controller/ProductoFacturaControlador.php",
            method: "GET",
            dataSrc: "",
            data: {
                accion: "listarFacturas"
            },
            error: function (xhr, error, thrown) {
                console.error("XHR response:", xhr.responseText);
            }
        },
        "columns": [
            { "data": "id" },
            { "data": "fecha" },
            { "data": "total" },
            {
                data: null,
                defaultContent: '<button onclick="verProductosFactura()">Ver más</button>',
            },
        ],
        buttons: [
            {
                extend: "pdfHtml5",
                download: "open",
                titleAttr: "Reporte de Compras (pdf)",
                title: "Reporte de Compras",
                filename: "ReporteCompras",
                text: "<i class='fa-solid fa-file-pdf'></i>",
                className: "pdf btn btn-danger",
                exportOptions: {
                    columns: [0, 1, 2]
                }
            },
            {
                extend: "print",
                titleAttr: "Reporte de Compras (imprimir)",
                title: "Reporte de Compras",
                filename: "ReporteCompras",
                text: "<i class='fa-solid fa-print'></i>",
                className: "imprimir btn btn-info",
                exportOptions: {
                    columns: [0, 1, 2]
                }
            }
        ],
        layout: {
            topStart: 'buttons'
        }
    });
});

function verProductosFactura() {
    console.log("sí sirvió");
}