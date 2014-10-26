<?php
class Problem extends Conectar
{
	private $get_problem;

	public function add_problem()
	{
		//formateando fecha del problema
        $fecha_problema=$_POST["fecha_problema"];
        $arreglo_fecha_problema = explode("/", $fecha_problema);
        $nueva_fecha_problema = $arreglo_fecha_problema['2']."-".$arreglo_fecha_problema['1']."-".$arreglo_fecha_problema['0'];

        $estado = "pendiente";
        $ses = $_SESSION["ses_id"];

		$query=sprintf
		(
			"insert into problemas values (null,'$estado',%s,'$nueva_fecha_problema',%s,'$ses');",
			parent::comillas_inteligentes($_POST["detalle_problema"]),
			parent::comillas_inteligentes($_POST["problema_activo"])
		);
		mysql_query($query);
		header("Location: ".Conectar::ruta()."?accion=problem_report&m=1"); //mantenimiento ingresado correctamente
	}

	public function get_problem()
	{
		$sql="select *, activos.id_activo, activos.nombre_activo, usuarios.id_usuario, usuarios.nombre_usuario, date_format(fecha_problema,'%d-%m-%Y') as fecha_problema from activos, usuarios, problemas where problemas.id_activo=activos.id_activo && problemas.id_usuario=usuarios.id_usuario order by problemas.id_problema desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_problem[]=$reg;
		}
		return $this->get_problem;
	}

	public function sol_problem()
	{
		if(isset($_GET["id_problema"]))
		{
			parent::con();
			$query=sprintf
			(
				"select estado_problema from problemas where id_problema='%s'",
				parent::comillas_inteligentes($_GET["id_problema"])
			);
			$res=mysql_query($query);
			if($reg=mysql_fetch_array($res))
			{
				$est_act = $reg["estado_problema"];

				if($est_act == "solucionado")
				{
					header("Location: ".Conectar::ruta()."?accion=msg_alert&m=3");
					exit;
				}
				else
				{
					$nuevo_estado = "solucionado";
					$sql=sprintf
					(
						"update problemas set estado_problema='$nuevo_estado' where id_problema=%s",
						parent::comillas_inteligentes($_GET["id_problema"])
					);
					mysql_query($sql);
					header("Location: ".Conectar::ruta()."?accion=msg_alert&m=1");
					exit;
				}
			}
		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=msg_alert&m=2");
			exit;
		}
	}
}
?>