<?php

function mValidarSesion()
{
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false)
    {
        echo "Inicia Sesion para acceder a este contenido.<br>";
        echo "<br><a href='../../index.html'>Login</a>";
        header(SERVIDOR.'index.html'); //redirige a la página de login si el usuario quiere ingresar sin iniciar sesion
        exit;
    }
}/*mValidarSesion*/

function mValidarTimeOut()
{
    $now = time();
    if($now > $_SESSION['expire'])
    {
        session_destroy();
        echo "Tu sesion a expirado, <a href='../../index.html'>Inicia Sesion</a>";
        header(SERVIDOR.'index.html');//redirige a la página de login, modifica la url a tu conveniencia
        exit;
    }
}/*mValidarTimeOut*/

?>