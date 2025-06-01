// Muestra un mensaje de error, éxito o advertencia utilizando SweetAlert2

export class SweetAlert {
    mostrarError(titulo, mensaje) {
        Swal.fire({
            title: titulo,
            text: mensaje,
            icon: "error"
        });
    }

    mostrarExito(titulo, mensaje) {
        Swal.fire({
            title: titulo,
            text: mensaje,
            icon: "success"
        });
    }

    mostrarAdvertencia(titulo, mensaje) {
        Swal.fire({
            title: titulo,
            text: mensaje,
            icon: "warning"
        });
    }
}