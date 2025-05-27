<?php
$error = false;

require_once __DIR__ . '/../../../feactures/users/model/Persona.php'; // si también usas esta clase
require_once __DIR__ . '/../../../feactures/users/model/Usuario.php';

if (isset($_POST["autenticar"])) {
    $correo = $_POST["correo"];
    $clave = md5($_POST["clave"]);
    $usuario = new Usuario(null, null, null, $correo, $clave);
    if ($usuario->autenticarUsuario()) {
        session_start();

        $_SESSION["id"] = $usuario->getIdPersona();

        // Si la petición viene desde Postman o fetch/AJAX
        if (!empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "Usuario autenticado correctamente",
                "id" => $_SESSION["id"]
            ]);
            exit;
        }
        header("location: ?pdi=src/feactures/users/views/control_panel.html");
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "error",
            "message" => "Credenciales incorrectas"
        ]);
        exit;
    }
}
?>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login y Registro</title>
      <link rel="stylesheet" href="public/assets/css/login.css" />
  </head>
    <script src="/urban-Pixel/public/assets/js/login.js" defer></script>
  <body>
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form
            method="post"
            class="data-form"
            autocomplete="off">
          <h1>Crear Cuenta</h1>
          <input
            type="text"
            name="nombre"
            maxlength="50"
            placeholder="Nombre completo"
            required
          />
          <input
            type="email"
            name="correo"
            maxlength="25"
            placeholder="Correo electrónico"
            required
          />
          <input
            type="password"
            name="clave"
            maxlength="25"
            placeholder="Contraseña"
            required
          />
          <button 
            class="btn btn--big" 
            type="submit" 
            name="registrarse">
            Registrarse
          </button>
        </form>
      </div>

      <div class="form-container sign-in-container">
        <form 
            method="post"
            class="data-form"
            action="?pdi=src/feactures/login/views/login.php">
          <h1>Iniciar Sesión</h1>
          <input 
            type="email"
            name="correo"
            maxlength="50" 
            placeholder="Correo electrónico" 
            required/>
          <input 
            type="password" 
            name="clave"
            placeholder="Contraseña" 
            required/>
          <button
            class="btn btn--big"
            type="submit"
            name="autenticar"
            >Ingresar</button>
        </form>
      </div>

      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1>¡Bienvenido!</h1>
            <p>¿Ya tienes una cuenta? Inicia sesión aquí.</p>
            <button class="ghost" id="signIn">Iniciar Sesión</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1>¡Hola de nuevo!</h1>
            <p>¿Aún no tienes cuenta? Regístrate aquí.</p>
            <button class="ghost" id="signUp">Registrarse</button>
          </div>
        </div>
      </div>
    </div>
  </body>
