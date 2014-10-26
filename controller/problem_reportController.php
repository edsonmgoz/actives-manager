<?php
require_once("config.php");
require_once("model/problemModel.php");
require_once("model/activeModel.php");
$p=new Problem();
$a=new Active();
$active = $a->get_activo();
if(isset($_POST["grabar"]) and $_POST["grabar"]=="si")
{
	$p->add_problem();
	exit;
}
require_once("view/problem_report.phtml");
?>