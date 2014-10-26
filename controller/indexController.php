<?php

if(isset($_SESSION["ses_id"]) and isset($_SESSION["privilegio"]) and $_SESSION["privilegio"]=='administrador')
{
	header("Location: ".Conectar::ruta()."?accion=administrador");
}

if(isset($_SESSION["ses_id"]) and isset($_SESSION["privilegio"]) and $_SESSION["privilegio"]=='encargado')
{
	header("Location: ".Conectar::ruta()."?accion=encargado");
}

if(isset($_SESSION["ses_id"]) and isset($_SESSION["privilegio"]) and $_SESSION["privilegio"]=='personal')
{
	header("Location: ".Conectar::ruta()."?accion=personal");
}

require_once("view/index.phtml");


?>