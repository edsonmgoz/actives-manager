<?php
require_once("config.php");
require_once("model/userModel.php");
$p=new Usuario();
$p->control_de_sesion_admin();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$p->add_user();
	exit;
}
require_once("view/add_user.phtml");
?>