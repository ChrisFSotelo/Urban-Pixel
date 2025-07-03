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
            Swal.fire({
                title: "Correo enviado!",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                document.getElementById("correo").value = "";
                window.location.href = "../../../../";
            });
        }
        else if(resultado.error)
            sweetAlert.mostrarError("Error", resultado.error);
    } 
    catch (error) {
        console.error("Error al enviar el correo: ", error);
        sweetAlert.mostrarError("Error", "Hubo un problema al enviar el correo. Por favor, inténtelo de nuevo más tarde.");
    }
}

$("#recuperarClave").click(function(e) {
    e.preventDefault();
    const sweetAlert = new SweetAlert();
    const clave = document.getElementById("clave");
    const claveRepetida = document.getElementById("claveRepetida");

    if(clave.value === ""){
        sweetAlert.mostrarError("Error", "Por favor, ingrese una clave.");
        return false;
    }

    if(claveRepetida.value === ""){
        sweetAlert.mostrarError("Error", "Por favor, ingrese la contraseña nuevamente.");
        return false;
    }

    if(clave.value !== claveRepetida.value){
        sweetAlert.mostrarError("Error", "Las contraseñas no coinciden.");
        return false;
    }

    recuperarClave(clave.value);
});

async function recuperarClave(clave) {
    const sweetAlert = new SweetAlert();
    const form = new FormData();
    const id = document.getElementById("id").value;
    const tipo = document.getElementById("tipo").value;
    form.append('nuevaClave', clave);

    try {
        const respuesta = await fetch(`../controller/RecuperarPasswordController.php?accion=recuperarClave&id=${id}&tipo=${tipo}`, {
            method: "POST",
            body: form
        });
        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            Swal.fire({
                title: "Cambio exitoso",
                text: resultado.mensaje,
                icon: "success"
            }).then(() => {
                document.getElementById("clave").value = "";
                document.getElementById("claveRepetida").value = "";
                window.location.href = "../../../../";
            });
        }
        else if(resultado.error)
            sweetAlert.mostrarError("Error", resultado.error);
    } 
    catch (error) {
        console.error("Error al cambiar la contraseña: ", error);
        sweetAlert.mostrarError("Error", "Hubo un problema al cambiar la contraseña. Por favor, inténtelo de nuevo más tarde.");
    }
}