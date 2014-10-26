<?php
require_once("config.php");
require_once("model/userModel.php");
$u=new Usuario();
$u->cambiar_estado();
?>