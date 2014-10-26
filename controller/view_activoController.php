<?php
require_once("config.php");
require_once("model/activeModel.php");
require_once("model/ufvModel.php");
$u=new Ufv();
// $ufv_inicial = $u->ufv_inicial();
// $ufv_final = $u->ufv_final();
$get_ufv = $u->get_ufv();
$a=new Active();
$activo=$a->get_activo();
require_once("view/view_activo.phtml");
?>