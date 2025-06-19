
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login y Registro</title>
  <link rel="stylesheet" href="public/assets/css/login.css" />
  <link rel="stylesheet" href="public/assets/css/progress_bar.css" />

</head>

<body>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
      <form
          method="post"
          id="formulario-registro"
          name="formulario-registro"
          class="data-form"
          autocomplete="off"
      >

        <h1>Crear Cuenta</h1>
          <?php
          include("components/progressBar.php")
          ?>

        <input
          type="text"
          id="nombre-registro"
          name="nombre"
          maxlength="30"
          placeholder="Nombre"
          required
        />

        <input
          type="text"
          id="apellido-registro"
          name="apellido"
          maxlength="30"
          placeholder="Apellido"
          required
        />

        <input
          type="email"
          name="correo"
          id="correo-registro"
          maxlength="50"
          placeholder="Correo electrónico"
          required
        />

        <input
          type="password"
          id="clave-registro"
          name="clave"
          maxlength="25"
          placeholder="Contraseña"
          required
        />

        <button
          class="btn btn--big"
          id="btn-registrarse"
          name="registrarse">
          Registrarse
        </button>
      </form>
    </div>

    <div class="form-container sign-in-container">
      <form
        method="post"
        id="formulario-inicio-sesion"
        class="data-form"
        autocomplete="on"
        action="?pdi=src/features/users/views/control_panel.php"
      >

        <h1>Iniciar Sesión</h1>

        <input
          type="email"
          id="correo-inicio-sesion"
          name="correo"
          maxlength="50"
          placeholder="Correo electrónico"
          required
        />

        <input
          type="password"
          id="clave-inicio-sesion"
          name="clave"
          placeholder="Contraseña"
          required
        />

        <button
          class="iniciar btn btn--big"
          id="btn-iniciar-sesion"
          name="autenticar">
          Ingresar
        </button>
<br>
        <a class="cambiar-clave" href="./src/features/users/views/enviarCorreo.php">¿Olvidaste tu contraseña?</a>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module" src="public/assets/js/login.js" defer></script>
<script src="public/assets/js/progressBar.js" defer></script>
