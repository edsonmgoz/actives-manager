<?php
require_once("config.php"); //por si se pierde la ruta de config
require_once("model/maintenanceModel.php");
$m=new Maintenance();
$m->complete_maintenance();
?>