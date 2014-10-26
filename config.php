<?php
session_start();
class Conectar
{
	public function con()
	{
		$con=mysql_connect("localhost","root","");
		mysql_query("SET NAMES 'utf8'");
		mysql_select_db("bd_am");
		return $con;

		// $con=mysql_connect("mysql.hostinger.es","u167335923_mvc","helloween");
		// mysql_query("SET NAMES 'utf8'");
		// mysql_select_db("u167335923_mvc");
		// return $con;

	}
	public static function ruta()
	{
		return "http://localhost/amanager/";
		// return "http://mvc.edsonmgoz.hol.es/";
	}
	public function comillas_inteligentes($valor)
	{
		// Retirar las barras
		if (get_magic_quotes_gpc()) {
			$valor = stripslashes($valor);
		}

		// Colocar comillas si no es entero
		if (!is_numeric($valor)) {
			$valor = "'" . mysql_real_escape_string($valor) . "'";
		}
		return $valor;
	}
}
?>