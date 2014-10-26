<?php
require_once("config.php");
require_once("model/userModel.php");
require_once("model/maintenanceModel.php");
require_once("model/activeModel.php");
$u=new Usuario();
$m=new Maintenance();
$a=new Active();
$personal = $u->get_personal();
$active = $a->get_activo();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$m->add_maintenance();
	exit;
}
require_once("view/assign_maintenance.phtml");
?>