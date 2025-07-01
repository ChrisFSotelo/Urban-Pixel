<?php
    class AuthController {
        public static function logout() {
            session_start();
            session_unset();
            session_destroy();
            header("Location: ../../../");
            exit;
        }
    }
?>