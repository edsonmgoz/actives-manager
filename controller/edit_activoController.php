<?php
require_once("config.php");
require_once("model/userModel.php");
require_once("model/activeModel.php");
require_once("model/categoryModel.php");
$c=new Category();
$categoria = $c->get_category();
$u=new Usuario();
$a=new Active();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
  $a->edit_activo();
  exit;
}
$personal = $u->get_personal();
$act=$a->get_activo_por_id();

require_once("view/edit_activo.phtml");
?>
