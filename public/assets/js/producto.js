$(document).ready(function() {
    tablaUsuarios = $("#tablaProductos").DataTable({ // Inicializar DataTable para la tabla de clientes
        responsive: true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json"
        },
        "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "Todos"]],
        ajax: {
            url: "/Urban-Pixel/src/features/productos/controller/ProductoControlador.php",
            method: "GET",
            dataSrc: "",
            data: {
                accion: "listar"
            }
        },
        "columns": [
            {"data" : "no"},
            {"data" : "nombre"},
            {"data" : "cantidad"},
            {"data" : "precio"},
            {"data" : "editar"},
            {"data" : "eliminar"},
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
                    columns: [0, 1, 2, 3]
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