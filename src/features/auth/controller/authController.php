<?php 
class Auth
{
    public static function auth(String $correo, String $clave)
    {
        $usuario = new Usuario(null, null, null, $correo, $clave);
        echo var_dump($usuario);
        if ($usuario->autenticarUsuario($usuario))
        {
            return [
                'rol' => 'admin',
                'id' => $usuario->getIdPersona(),
            ];
        } else
        {
            echo "No se pudo autenticar el usuario";
        }
    }
}
?>