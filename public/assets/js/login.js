import { SweetAlert } from "./mensajes.js";

const sweetAlert = new SweetAlert();
const signUpButton = document.getElementById("signUp");
const signInButton = document.getElementById("signIn");
const container = document.getElementById("container");
const formularioInicioSesion = document.getElementById("formulario-inicio-sesion");
const formularioRegistro = document.getElementById("formulario-registro");
const botonRegistro = document.getElementById("btn-registrarse");
const botonIniciarSesion = document.getElementById("btn-iniciar-sesion");
const registroCampos = [
  document.getElementById("nombre-registro"),
  document.getElementById("apellido-registro"),
  document.getElementById("correo-registro"),
  document.getElementById("clave-registro")
];
const barraProgreso = document.getElementById("barra-progreso");

// Evento para cambiar entre formularios de registro e inicio de sesión
signUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

// Evento para cambiar de vuelta al formulario de inicio de sesión
signInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

// Validación de formulario de registro
botonRegistro.addEventListener("click", (event) => {
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

  formularioRegistro.submit();
});

// Validación de formulario de inicio de sesión
botonIniciarSesion.addEventListener("click", (event) => {
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

  formularioInicioSesion.submit();
});

// Actualización de la barra de progreso en el formulario de registro
registroCampos.forEach(campo => {
  campo.addEventListener("input", actualizarBarraProgreso);
});

// Función para actualizar la barra de progreso
function actualizarBarraProgreso() {
  const total = registroCampos.length;
  let completados = 0;

  registroCampos.forEach(campo => {
    if(campo.value.trim() !== "")
      completados++;
  });

  const porcentaje = (completados / total) * 100;
  barraProgreso.style.width = `${porcentaje}%`;
}
