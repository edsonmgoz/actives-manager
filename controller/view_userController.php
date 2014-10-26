<?php
require_once("config.php");
require_once("model/userModel.php");
$u=new Usuario();
$u->control_de_sesion_admin();
$usuario=$u->get_usuario();
require_once("view/view_user.phtml");
?>