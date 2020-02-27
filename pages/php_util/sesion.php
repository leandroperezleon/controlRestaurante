<?php

function mValidarSesion()
{
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false)
    {
        echo "Inicia Sesion para acceder a este contenido.<br>";
        echo "<a href='../../index.html'>Inicio Sesion</a>";
        header(SERVIDOR.'index.html'); // dirige a la página login cuando el usuario quiere ingresar sin iniciar sesion
        exit;
    }
}/*mValidarSesion*/

function mValidarTimeOut()
{
    $now = time();
    if($now > $_SESSION['expire'])
    {
        session_destroy();
        echo "Tu sesion a expirado. <br>";
        echo "<a href='../../index.html'>Inicio Sesion</a>";
        header(SERVIDOR.'index.html');// dirige a la página de login
        exit;
    }
}/*mValidarTimeOut*/

?>