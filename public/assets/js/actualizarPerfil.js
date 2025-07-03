$("#submit-btn-profile").click(function(e) { // Evento para el botón de enviar del formulario
    e.preventDefault();
    const correoRegex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    const id = document.getElementById("id");
    const idRol = document.getElementById("idRol");
    const nombre = document.getElementById("nombre");
    const apellido = document.getElementById("apellido");
    const correo = document.getElementById("correo");
    const clave = document.getElementById("clave");

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

    if(Number(idRol.value) === 1)
        actualizarPerfilAdmin(id, nombre, apellido, correo, clave);
    else if(Number(idRol.value) === 2)
        actualizarPerfilCliente(id, nombre, apellido, correo, clave);
});

async function actualizarPerfilAdmin(id, nombre, apellido, correo, clave) {
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

        if(resultado.mensaje)
            actualizarSesionAdmin(id.value);
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

async function actualizarPerfilCliente(id, nombre, apellido, correo, clave) {
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

        if(resultado.mensaje)
            actualizarSesionCliente(id.value);
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

async function actualizarSesionCliente(idCliente) {
    try {
        const respuesta = await fetch(`../controller/ClienteControlador.php?accion=actualizarSesion&id=${idCliente}`, {
            method: "GET"
        });

        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            // Mostrar loading
            Swal.fire({
                title: 'Actualizando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 1500,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                document.getElementById("clave").value = '';

                Swal.fire({
                    title: "Actualización completa",
                    text: resultado.mensaje,
                    icon: "success"
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
    catch(error) {
        console.error("Error al actualizar: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el cliente. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}

async function actualizarSesionAdmin(idAdmin) {
    try {
        const respuesta = await fetch(`../controller/UsuarioControlador.php?accion=actualizarSesion&id=${idAdmin}`, {
            method: "GET"
        });

        const resultado = await respuesta.json();

        if(resultado.mensaje) {
            // Mostrar loading
            Swal.fire({
                title: 'Actualizando...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 1500,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                document.getElementById("clave").value = '';

                Swal.fire({
                    title: "Actualización completa",
                    text: resultado.mensaje,
                    icon: "success"
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
    catch(error) {
        console.error("Error al actualizar: ", error);

        Swal.fire({
            title: "Error",
            text: "Hubo un problema al actualizar el admin. Por favor, inténtelo de nuevo más tarde.",
            icon: "error"
        });
    }
}