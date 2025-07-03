<?php 

if (isset($_SESSION["usuario"])) {
    include("NavbarConSesion.php");
} else {
    include("NavbarSinSesion.php");
}

?>