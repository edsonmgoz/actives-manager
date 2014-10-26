<?php
require_once("config.php");
require_once("model/maintenanceModel.php");
$m=new Maintenance();
$record=$m->get_maintenance();
require_once("view/record_assignments.phtml");
?>