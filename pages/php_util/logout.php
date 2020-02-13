<?php
ob_start();
session_start();
unset ($_SESSION['username']);
session_destroy();

include 'parametros.php';
header(SERVIDOR.'index.html');
ob_end_flush();
?>