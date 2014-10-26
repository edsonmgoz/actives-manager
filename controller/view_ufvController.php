<?php
require_once("config.php");
require_once("model/ufvModel.php");
$u = new Ufv();
$verifica = $u->verifica();
$enero = $u->get_enero();
$febrero = $u->get_febrero();
$marzo = $u->get_marzo();
$abril = $u->get_abril();
$mayo = $u->get_mayo();
$junio = $u->get_junio();
$julio = $u->get_julio();
$agosto = $u->get_agosto();
$septiembre = $u->get_septiembre();
$octubre = $u->get_octubre();
$noviembre = $u->get_noviembre();
$diciembre = $u->get_diciembre();
require_once("view/view_ufv.phtml");
?>