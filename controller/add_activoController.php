<?php
require_once("config.php");
require_once("model/userModel.php");
require_once("model/activeModel.php");
require_once("model/categoryModel.php");
$c=new Category();
$categoria = $c->get_category();
$u=new Usuario();
$a=new Active();
$personal = $u->get_personal();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$a->add_activo();
	exit;
}
require_once("view/add_activo.phtml");
?>