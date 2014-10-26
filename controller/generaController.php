<?php
require_once("config.php");
require_once("model/ufvModel.php");
$u=new Ufv();
$u->generar();
require_once("view/genera.phtml");
?>