<?php
require_once("config.php"); //por si se pierde la ruta de config
require_once("model/userModel.php");
$u=new Usuario();
$u->control_de_sesion_admin();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
  $u->edit_user();
  exit;
}
$usu=$u->get_usuario_por_id();

require_once("view/edit_user.phtml");
?>
