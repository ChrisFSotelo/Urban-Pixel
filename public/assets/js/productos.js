import { SweetAlert } from './mensajes.js';

const alerta = new SweetAlert();


if (window.location.search.includes('registro=exito')) {
    alerta.mostrarExito("¡Éxito!", "Producto registrado correctamente");
}

if (window.location.search.includes('registro=error')) {
    alerta.mostrarError("¡Error!", "No se pudo registrar el producto");
}