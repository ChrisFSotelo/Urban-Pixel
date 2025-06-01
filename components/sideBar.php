<? require_once (__DIR__ . '/../src/features/Auth/controllers/AuthController.php') ?>
<!-- Asegúrate de tener Bootstrap y JS en tu <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .sidebar {
        width: 250px;
        height: 100vh; /* ocupa toda la altura visible */
        transition: width 0.2s;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar .nav-link {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar.collapsed .nav-link span {
        display: none;
    }

    .sidebar.collapsed .nav-link i {
        margin-right: 0;
    }

    .content {
        transition: margin-left 0.3s;
        margin-left: 250px;
    }

    .content.collapsed {
        margin-left: 80px;
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-dark text-white sidebar p-3">
        <button id="toggleSidebar" class="btn btn-outline-light w-100 mb-3">
            ☰
        </button>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="#inicio">
                    <i class="fas fa-home"></i> <span>Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#productos">
                    <i class="fas fa-box"></i> <span>Productos</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#nosotros">
                    <i class="fas fa-users"></i> <span>Nosotros</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#contacto">
                    <i class="fas fa-envelope"></i> <span>Contacto</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="<?php echo "src/features/Auth/logout.php" ?>">
                    <i class="fas fa-sign-in-alt"></i> <span>Cerrar Sesión</span>
                <a class="nav-link text-white" href="?pdi=<?php echo base64_encode('src/features/login/views/login.php'); ?>">
                    <i class="fas fa-sign-in-alt"></i> <span>Iniciar Sesión</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Font Awesome para los iconos -->
<script src="https://kit.fontawesome.com/a2d0411d4e.js" crossorigin="anonymous"></script>

<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('collapsed');
    });
</script>
