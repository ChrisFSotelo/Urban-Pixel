<?php
$error = false;

require_once __DIR__ . '/../../../features/users/models/Persona.php'; // si también usas esta clase
require_once __DIR__ . '/../../../features/users/models/Usuario.php';

if (isset($_POST["autenticar"])) {
    $email = $_POST["email"];
    $clave = md5($_POST["clave"]);
    $usuario = new Usuario(null, null, null, $email, $clave);
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
        header("location: ?pdi=" . base64_encode(__DIR__ . '/../../../features/users/views/control_panel.html'));
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
            action="?pdi=<?php echo base64_encode(__DIR__ . '/login.php'); ?>">
            <label for="email">Ingresa tu correo</label>
            <input type="email" name="email" placeholder="Correo" required />

            <label for="clave">Ingresa tu contraseña</label>
            <input type="password" name="clave" placeholder="Clave" required />
            <a href="#">Olvidé mi contraseña</a>
            <button class="btn btn--big" type="submit" name="autenticar">Iniciar sesion</button>
        </form>
    </section>
</main>