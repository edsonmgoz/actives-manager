<?php
require_once("config.php");
require_once("model/problemModel.php");
$p=new Problem();
$problema=$p->get_problem();
require_once("view/msg_alert.phtml");
?>