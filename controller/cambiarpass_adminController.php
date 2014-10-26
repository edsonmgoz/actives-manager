<?php
require_once("config.php");
require_once("model/userModel.php");
$u=new Usuario();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$u->cambiarpass_admin();
	exit;
}
$u->get_usuario_por_id();
$u->control_de_sesion_admin();
// $perfilgral=$u->get_usuario_por_ses();
require_once("view/cambiarpass_admin.phtml");
?>
