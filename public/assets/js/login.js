import { SweetAlert } from "./mensajes.js";

const sweetAlert = new SweetAlert();
const signUpButton = document.getElementById("signUp");
const signInButton = document.getElementById("signIn");
const container = document.getElementById("container");
const formularioInicioSesion = document.getElementById("formulario-inicio-sesion");
const formularioRegistro = document.getElementById("formulario-registro");
const botonRegistro = document.getElementById("btn-registrarse");
const botonIniciarSesion = document.getElementById("btn-iniciar-sesion");

// Evento para cambiar entre formularios de registro e inicio de sesión
signUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

// Evento para cambiar de vuelta al formulario de inicio de sesión
signInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

// Validación de formulario de registro
botonRegistro.addEventListener("click", async (event) => {
  event.preventDefault();
  const correoRegex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
  const nombre = document.getElementById("nombre-registro");
  const apellido = document.getElementById("apellido-registro");
  const correo = document.getElementById("correo-registro");
  const clave = document.getElementById("clave-registro");

  if(nombre.value === ""){
    sweetAlert.mostrarError("Error", "Por favor, ingrese su nombre.");
    return false;
  }

  if(apellido.value === ""){
    sweetAlert.mostrarError("Error", "Por favor, ingrese su apellido.");
    return false;
  }

  if(correo.value === ""){
    sweetAlert.mostrarError("Error", "Por favor, ingrese su correo electrónico.");
    return false;
  }

  if(!correoRegex.test(correo.value)){
    sweetAlert.mostrarError("Error", "Por favor, ingrese un correo electrónico válido.");
    return false;
  }

  if(clave.value === ""){
    sweetAlert.mostrarError("Error", "Por favor, ingrese una clave.");
    return false;
  }
  // Construir FormData con los valores
    const datos = new FormData();
    datos.append("nombre", nombre.value);
    datos.append("apellido", apellido.value);
    datos.append("correo", correo.value);
    datos.append("clave", clave.value);
  try {
    const respuesta = await fetch("src/features/users/controller/ClienteControlador.php?accion=registrar", {
      method: "POST",
      body: datos
    });

    const resultado = await respuesta.json();

    if (resultado.mensaje) {
      Swal.fire({
        title: '¡Registro exitoso!',
        text: resultado.mensaje,
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = "../urban-Pixel"; // ⬅ cámbialo por la página deseada
      });
    } else if (resultado.error) {
      Swal.fire({
        title: 'Error',
        text: resultado.error,
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }

  } catch (error) {
    console.error("Error al registrar:", error);
    sweetAlert.mostrarError("Error", "No se pudo completar el registro");
  }
});

// Validación de formulario de inicio de sesión
botonIniciarSesion.addEventListener("click", async (event) => {
  event.preventDefault();
  const correoRegex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
  const correo = document.getElementById("correo-inicio-sesion");
  const clave = document.getElementById("clave-inicio-sesion");

  if(correo.value === ""){
    sweetAlert.mostrarError("Error", "Por favor, ingrese su correo electrónico.");
    return false;
  }

  if(!correoRegex.test(correo.value)){
    sweetAlert.mostrarError("Error", "Por favor, ingrese un correo electrónico válido.");
    return false;
  }

  if(clave.value === ""){
    sweetAlert.mostrarError("Error", "Por favor, ingrese su clave.");
    return false;
  }

  // Construir FormData con los valores
  const datos = new FormData();
  datos.append("correo", correo.value);
  datos.append("clave", clave.value);
  try {
    const respuesta = await fetch("src/features/users/controller/UsuarioControlador.php?accion=autenticar", {
      method: "POST",
      body: datos
    });

    const resultado = await respuesta.json();

    if (resultado.error) {
      Swal.fire({
        title: 'Error',
        text: resultado.error,
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }

    const rol = resultado.usuario.rol;

    // Redirige según el rol
    if (rol === "usuario") {
      if (resultado.mensaje) {
        Swal.fire({
          title: '¡Usuario Autenticado Correctamente!',
          text: resultado.mensaje,
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = "src/features/users/views/control_panel.php";
        });
      }
    } else if (rol === 2 || rol === "2") {
      if (resultado.mensaje) {
        Swal.fire({
          title: '¡Cliente Autenticado Correctamente!',
          text: resultado.mensaje,
          icon: 'success',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = "index.php?pdi=src/features/users/views/landing_page.php";
        });
      }
    } else {
      alert("Rol no reconocido");
    }
    if (resultado.mensaje) {
      Swal.fire({
        title: '¡Usuario Autenticado Correctamente!',
        text: resultado.mensaje,
        icon: 'success',
        confirmButtonText: 'OK'
      }).then(() => {
        window.location.href = "src/features/users/views/control_panel.php";
      });
    }

  } catch (error) {
    console.error("Error al registrar:", error);
    sweetAlert.mostrarError("Error", "No se pudo completar el registro 2");
  }
});
