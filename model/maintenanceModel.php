<?php
class Maintenance extends Conectar
{
	private $get_my_maintenance;
	private $get_maintenance;

	public function add_maintenance()
	{
		//formateando fecha inicio
        $fecha_inicio=$_POST["fecha_inicio"];
        $arreglo_fecha_inicio = explode("/", $fecha_inicio);
        $nueva_fecha_inicio = $arreglo_fecha_inicio['2']."-".$arreglo_fecha_inicio['1']."-".$arreglo_fecha_inicio['0'];

		//formateando fecha fin
        $fecha_fin=$_POST["fecha_fin"];
        $arreglo_fecha_fin = explode("/", $fecha_fin);
        $nueva_fecha_fin = $arreglo_fecha_fin['2']."-".$arreglo_fecha_fin['1']."-".$arreglo_fecha_fin['0'];

        $estado = "pendiente";

		$query=sprintf
		(
			"insert into mantenimientos values (null,'$estado','$nueva_fecha_inicio','$nueva_fecha_fin',%s,%s);",
			parent::comillas_inteligentes($_POST["personal_activo"]),
			parent::comillas_inteligentes($_POST["mantenimiento_activo"])
		);
		mysql_query($query);
		header("Location: ".Conectar::ruta()."?accion=assign_maintenance&m=1"); //mantenimiento ingresado correctamente
	}

	public function get_maintenance()
	{
		$sql="select *, activos.id_activo, activos.nombre_activo, usuarios.id_usuario, usuarios.nombre_usuario, date_format(fecha_inicio,'%d-%m-%Y') as fecha_inicio, date_format(fecha_fin,'%d-%m-%Y') as fecha_fin from mantenimientos, activos, usuarios where mantenimientos.id_activo=activos.id_activo && mantenimientos.id_usuario=usuarios.id_usuario order by mantenimientos.id_mantenimiento desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_maintenance[]=$reg;
		}
		return $this->get_maintenance;
	}

	public function get_my_maintenance()
	{
		$ses = $_SESSION["ses_id"];
		$sql="select *, activos.id_activo, activos.nombre_activo, date_format(fecha_inicio,'%d-%m-%Y') as fecha_inicio, date_format(fecha_fin,'%d-%m-%Y') as fecha_fin from activos, mantenimientos where mantenimientos.id_activo=activos.id_activo && mantenimientos.id_usuario='$ses' order by mantenimientos.id_mantenimiento desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_my_maintenance[]=$reg;
		}
		return $this->get_my_maintenance;
	}

	public function complete_maintenance()
	{
		if(isset($_GET["id_mantenimiento"]))
		{
			parent::con();
			$query=sprintf
			(
				"select estado_mantenimiento from mantenimientos where id_mantenimiento='%s'",
				parent::comillas_inteligentes($_GET["id_mantenimiento"])
			);
			$res=mysql_query($query);
			if($reg=mysql_fetch_array($res))
			{
				$est_act = $reg["estado_mantenimiento"];

				if($est_act == "concluido")
				{
					header("Location: ".Conectar::ruta()."?accion=my_maintenance&m=3");
					exit;
				}
				else
				{
					$nuevo_estado = "concluido";
					$sql=sprintf
					(
						"update mantenimientos set estado_mantenimiento='$nuevo_estado' where id_mantenimiento=%s",
						parent::comillas_inteligentes($_GET["id_mantenimiento"])
					);
					mysql_query($sql);
					header("Location: ".Conectar::ruta()."?accion=my_maintenance&m=1");
					exit;
				}
			}
		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=my_maintenance&m=2");
			exit;
		}
	}

	public function delete_maintenance()
	{
		if(isset($_GET["id_mantenimiento"]))
		{
			parent::con();

			$sql=sprintf
			(
				"delete from mantenimientos where id_mantenimiento=%s",
				parent::comillas_inteligentes($_GET["id_mantenimiento"])
			);
			mysql_query($sql);

			header("Location: ".Conectar::ruta()."?accion=record_assignments&m=1");
			exit;

		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=record_assignments&m=2");
			exit;
		}
	}
}
?>