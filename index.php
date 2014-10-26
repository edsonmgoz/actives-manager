<?php
require_once("config.php");
if(isset($_SESSION["ses_id"]))
{
	if(!empty($_GET["accion"]))
	{
		$accion=$_GET["accion"];
	}
	else
	{
		$accion="index";
	}

	if(is_file("controller/".$accion."Controller.php"))
	{
		require_once("controller/".$accion."Controller.php");
	}
	else
	{
		require_once("controller/errorController.php");
	}
}
elseif(isset($_GET["accion"]) and $_GET["accion"]=="logueo")
{
	require_once("controller/logueoController.php");
}
elseif(isset($_GET["accion"]) and $_GET["accion"]=="demo_video")
{
	require_once("controller/demo_videoController.php");
}
elseif(isset($_GET["accion"]) and $_GET["accion"]=="view_activo")
{
	require_once("controller/view_activoController.php");
}
elseif(isset($_GET["accion"]) and $_GET["accion"]=="about")
{
	require_once("controller/aboutController.php");
}
elseif(isset($_GET["accion"]) and $_GET["accion"]=="view_ufv")
{
	require_once("controller/view_ufvController.php");
}
else
{
	require_once("controller/indexController.php");
}

?>