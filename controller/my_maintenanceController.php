<?php
require_once("config.php");
require_once("model/userModel.php");
require_once("model/maintenanceModel.php");
$m=new Maintenance();
$u=new Usuario();
$usu=$u->saluda_al_usuario($_SESSION["ses_id"]);
$mimante=$m->get_my_maintenance();
require_once("view/my_maintenance.phtml");
?>