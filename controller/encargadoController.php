<?php
require_once("model/userModel.php");
$u=new Usuario();
$usu=$u->saluda_al_usuario($_SESSION["ses_id"]);
$u->control_de_sesion_encargado();
$perfilgral=$u->get_usuario_por_ses();
require_once("view/encargado.phtml");
?>