<?php
require_once("config.php"); //por si se pierde la ruta de config
require_once("model/problemModel.php");
$p=new Problem();
$p->sol_problem();
?>