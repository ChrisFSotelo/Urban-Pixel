<? require_once (__DIR__ . '/../src/features/Auth/controllers/AuthController.php') ?>

<link rel="stylesheet" href="../../../../public/assets/css/sidebar.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" 
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="d-flex">
    <div id="sidebar" class="bg-dark text-white sidebar m-0 p-2">
        <button id="toggleSidebar" class="btn btn-outline-light w-100 mb-3">
            ☰
        </button>

        <ul class="nav flex-column gap-2">
            <li class="optionToSelect nav-item" id="inicio">
                <a class="nav-link text-white" title="Inicio">
                    <i class="fas fa-home"></i> <span>Inicio</span>
                </a>
            </li>

            <li class="optionToSelect nav-item" id="productos">
                <a class="nav-link text-white" title="Productos">
                    <i class="fas fa-box"></i> <span>Productos</span>
                </a>
            </li>

            <li class="optionToSelect nav-item" id="usuarios">
                <a class="nav-link text-white" title="Usuarios">
                    <i class="fas fa-user"></i> <span>Usuarios</span>
                </a>
            </li>

            <li class="optionToSelect nav-item" id="nosotros">
                <a class="nav-link text-white" title="Nosotros">
                    <i class="fas fa-users"></i> <span>Nosotros</span>
                </a>
            </li>

            <li class="optionToSelect nav-item" id="contacto">
                <a class="nav-link text-white" title="Contacto">
                    <i class="fas fa-envelope"></i> <span>Contacto</span>
                </a>
            </li>

            <li class="optionToSelect nav-item">
                <a class="nav-link text-white" title="Cerrar Sesión" href="<?php echo "../../../../src/features/Auth/logout.php" ?>">
                    <i class="fas fa-sign-in-alt"></i> <span>Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const options = document.querySelectorAll('.optionToSelect');

    const autoCollapseSidebar = () => {
        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
            if (mainContent) mainContent.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            if (mainContent) mainContent.classList.remove('collapsed');
        }
    };

    // Detectar cambio de tamaño de pantalla
    window.addEventListener('resize', autoCollapseSidebar);
    window.addEventListener('load', autoCollapseSidebar); // ejecutar al inicio

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        if (mainContent) mainContent.classList.toggle('collapsed');
    });

    options.forEach(option => {
        option.addEventListener('click', () => {
            options.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
        });
    });
</script>

