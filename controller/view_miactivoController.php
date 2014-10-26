<?php
require_once("config.php");
require_once("model/activeModel.php");
require_once("model/userModel.php");
$u=new Usuario();
$usu=$u->saluda_al_usuario($_SESSION["ses_id"]);
$a=new Active();
$miactivo=$a->get_mi_activo();
require_once("view/view_miactivo.phtml");
?>