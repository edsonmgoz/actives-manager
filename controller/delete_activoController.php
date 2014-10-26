<?php
require_once("config.php"); //por si se pierde la ruta de config
require_once("model/activeModel.php");
$a=new Active();
$a->delete_activo();
?>