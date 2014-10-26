<?php
require_once("config.php");
require_once("model/userModel.php");
$u=new Usuario();
$perfil=$u->get_perfil();
$u->control_de_sesion_admin();
//$perfilgral=$u->get_usuario_por_ses();
require_once("view/perfil_admin.phtml");
?>