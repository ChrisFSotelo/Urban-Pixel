<?php

$error = false;

require_once __DIR__ . "/../../auth/controller/authController.php";
require_once __DIR__ . '/../../../features/users/model/Persona.php'; // si también usas esta clase
require_once __DIR__ . '/../../../features/users/model/Usuario.php';

if (isset($_POST["autenticar"])) {
    $correo = $_POST["email"];
    $clave = $_POST["clave"];

    $resultado = Auth::auth($correo, $clave);

    if (is_array($resultado))
    {
        if ($resultado['rol'] === 'admin')
        {
            session_start();
            $_SESSION['id'] = $resultado['id'];
            echo "\nid sesión: " . $_SESSION['id'];
            echo "\nrol: " . $resultado['rol'];
            echo "\nid: " . $resultado['id'];
            header("location: /control_panel");
        }
        
    } else {
        $error = true;
    }

    // $usuario = new Usuario(null, null, null, $email, $clave);
    // if ($usuario->autenticarUsuario()) {
    //     session_start();

    //     $_SESSION["id"] = $usuario->getIdPersona();

    //     // Si la petición viene desde Postman o fetch/AJAX
    //     if (!empty($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    //         header('Content-Type: application/json');
    //         echo json_encode([
    //             "status" => "success",
    //             "message" => "Usuario autenticado correctamente",
    //             "id" => $_SESSION["id"]
    //         ]);
    //         exit;
    //     }
    //     header("location: /control_panel");
    //     exit;
    // } else {
    //     header('Content-Type: application/json');
    //     echo json_encode([
    //         "status" => "error",
    //         "message" => "Credenciales incorrectas"
    //     ]);
    //     exit;
    // }
}
?>

<head>
    <link rel="stylesheet" href="public/assets/css/login_styles.css" />
</head>

<main class="login-page">
    <section class="login-visual">
        <div class="flex-img">
            <img class="image-logo animated" src="public/assets/images/Urban_logo.png" alt="Urban Logo" />
        </div>
    </section>

    <!-- Formulario -->
    <section class="login-form">
        <header>
            <h1>
                <a href="index.php" title="Página principal">Urban Pixel</a>
            </h1>
            <h2>Inicie sesion para continuar</h2>
        </header>

        <form method="post"
            class="data-form"
            action="/login">
            <label for="email">Ingresa tu correo</label>
            <input type="email" name="email" maxlength="50" placeholder="Correo" required />

            <label for="clave">Ingresa tu contraseña</label>
            <input type="password" name="clave" maxlength="25" placeholder="Clave" required />
            <a href="#">Olvidé mi contraseña</a>
            <button class="btn btn--big" type="submit" name="autenticar">Iniciar sesion</button>
        </form>
    </section>
</main>