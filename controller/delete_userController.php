<?php
require_once("config.php"); //por si se pierde la ruta de config
require_once("model/userModel.php");
$u=new Usuario();
$u->delete_user();
?>