import { SweetAlert } from "./mensajes.js";

$("#enviarCorreo").click(function(e) {
    e.preventDefault();
    const sweetAlert = new SweetAlert();
    const correoRegex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    const correo = document.getElementById("correo");

    if(correo.value === ""){
        sweetAlert.mostrarError("Error", "Por favor, ingrese un correo.");
        return false;
    }

    if(!correoRegex.test(correo.value)){
        sweetAlert.mostrarError("Error", "Por favor, ingrese un correo valido.");
        return false;
    }

    enviarCorreo(correo.value);
});

async function enviarCorreo(correo) {
    const sweetAlert = new SweetAlert();
    const form = new FormData();
    form.append('correo', correo);

    // Mostrar loading
    Swal.fire({
        title: 'Enviando correo...',
        text: 'Por favor espere',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const respuesta = await fetch("../controller/RecuperarPasswordController.php?accion=enviarCorreo", {
            method: "POST",
            body: form
        });

        const resultado = await respuesta.json();
        Swal.close(); // Cierra el loading

        if(resultado.mensaje) {
            sweetAlert.mostrarExito("Correo enviado!", resultado.mensaje);
            document.getElementById("correo").value = "";
        }
        else if(resultado.error)
            sweetAlert.mostrarError("Error", resultado.error);
    } 
    catch (error) {
        console.error("Error al enviar el correo: ", error);
        sweetAlert.mostrarError("Error", "Hubo un problema al enviar el correo. Por favor, inténtelo de nuevo más tarde.");
    }
}