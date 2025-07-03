<!-- Agrega esto en el <head> de tu documento -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- NAVBAR BOOTSTRAP -->
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <?php 
            if (str_contains($_SERVER["REQUEST_URI"], 'src')) {
        ?>
            <a class="navbar-brand fw-bold text-uppercase" href="../../../../">Urban Pixel</a>
        <?php } ?>

        <?php 
            if(!str_contains($_SERVER["REQUEST_URI"], 'src')) {
        ?>
            <a class="navbar-brand fw-bold text-uppercase" href="./">Urban Pixel</a>
        <?php } ?>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php 
                        if (str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <a class="nav-link active" aria-current="page" href="../../../../">Inicio</a>
                    <?php } ?>

                    <?php 
                        if(!str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <a class="nav-link active" aria-current="page" href="./">Inicio</a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php 
                        if (str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <a class="nav-link active" aria-current="page" href="../../../../src/features/inicio/views/nosotros.php">Nosotros</a>
                    <?php } ?>

                    <?php 
                        if(!str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <a class="nav-link active" aria-current="page" href="src/features/inicio/views/nosotros.php">Nosotros</a>
                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php 
                        if (str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <a class="nav-link active" aria-current="page" href="../../../../src/features/inicio/views/contacto.php">Contacto</a>
                    <?php } ?>

                    <?php 
                        if(!str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <a class="nav-link active" aria-current="page" href="src/features/inicio/views/contacto.php">Contacto</a>
                    <?php } ?>
                </li>
            </ul>
            <ul class="navbar-nav">
                <?php 
                        if (str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <li class="nav-item"><a href="../../../../src/features/login/views/login.php" class="nav-link"
                            aria-disabled="true">Iniciar Sesion</a></li>
                    <?php } ?>

                    <?php 
                        if(!str_contains($_SERVER["REQUEST_URI"], 'src')) {
                    ?>
                        <li class="nav-item"><a href="src/features/login/views/login.php" class="nav-link"
                            aria-disabled="true">Iniciar Sesion</a></li>
                    <?php } ?>
            </ul>
        </div>
    </nav>
</header>