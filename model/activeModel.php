<?php
class Active extends Conectar
{
	private $get_activo;
	private $get_activo_por_id;
	private $get_miactivo;

	public function add_activo()
	{
			if(($_FILES["ubicacion_activo"]["type"]=="image/jpeg") and ($_FILES["foto_activo"]["type"]=="image/jpeg"))
			{
				if(($_FILES["ubicacion_activo"]["size"] < 2097152) and ($_FILES["foto_activo"]["size"] < 2097152))
				{
					//formateando fecha
                    $fecha_ingreso=$_POST["fecha_ingreso"];
                    $arreglo_fecha = explode("/", $fecha_ingreso);
                    $nueva_fecha_ingreso = $arreglo_fecha['2']."-".$arreglo_fecha['1']."-".$arreglo_fecha['0'];

					//Validando que codigo de activo no se repita
					parent::con();
					$sql=sprintf
					(
						"select codigo_activo from activos where codigo_activo=%s",
						parent::comillas_inteligentes($_POST["codigo_activo"])
					);
					$res=mysql_query($sql);
					if(mysql_num_rows($res)==0)
					{
						//Subiendo foto de ubicacion de activo
						$ubicacion_activo=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["ubicacion_activo"]["name"];
						$ubicacion_activoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["ubicacion_activo"]["name"]);
						copy($_FILES["ubicacion_activo"]["tmp_name"],"ubicaciones/$ubicacion_activoutf");

						//Subiendo foto de activo
						$foto_activo=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto_activo"]["name"];
						$foto_activoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto_activo"]["name"]);
						copy($_FILES["foto_activo"]["tmp_name"],"activos/$foto_activoutf");

						$query=sprintf
						(
							"insert into activos values (null,%s,%s,'$nueva_fecha_ingreso',%s,%s,%s,%s,'$ubicacion_activo','$foto_activo',%s,%s,%s);",
							parent::comillas_inteligentes($_POST["codigo_activo"]),
							parent::comillas_inteligentes($_POST["nombre_activo"]),
							parent::comillas_inteligentes($_POST["detalle_activo"]),
							parent::comillas_inteligentes($_POST["cantidad_activo"]),
							parent::comillas_inteligentes($_POST["tipo_activo"]),
							parent::comillas_inteligentes($_POST["precio_activo"]),
							parent::comillas_inteligentes($_POST["vida_util"]),
							parent::comillas_inteligentes($_POST["personal_activo"]),
							parent::comillas_inteligentes($_POST["categoria_activo"])
						);
						mysql_query($query);
						header("Location: ".Conectar::ruta()."?accion=add_activo&m=3"); //activo ingresado correctamente
					}
					else
					{
						header("Location: ".Conectar::ruta()."?accion=add_activo&m=4"); //Se le redirecciona si el codigo es repetido
					}
				}
				else// La foto no debe exceder los 2 mb
				{
					header("Location: ".Conectar::ruta()."?accion=add_activo&m=1");
				}
			}
			else //solo jpg
			{
				header("Location: ".Conectar::ruta()."?accion=add_activo&m=2");
			}
	}

	public function get_activo()
	{
		$sql="select *, usuarios.id_usuario, usuarios.nombre_usuario, categorias.id_cat, categorias.porcentaje_cat, date_format(fecha_ingreso,'%d-%m-%Y') as fecha_ingreso from usuarios, activos, categorias where activos.id_usuario=usuarios.id_usuario && activos.id_cat=categorias.id_cat order by id_activo desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_activo[]=$reg;
		}
		return $this->get_activo;
	}

	public function get_mi_activo()
	{
		$ses = $_SESSION["ses_id"];
		$sql="select *, date_format(fecha_ingreso,'%d-%m-%Y') as fecha_ingreso from activos where id_usuario='$ses' order by id_activo desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_miactivo[]=$reg;
		}
		return $this->get_miactivo;
	}

	public function get_activo_por_id()
	{
		if(isset($_GET['id_activo']) and $_GET['id_activo'] > 0)
		{
			parent::con();
			$sql=sprintf
			(
				"select *, usuarios.id_usuario, usuarios.nombre_usuario, categorias.id_cat, categorias.nombre_cat, date_format(fecha_ingreso,'%%d/%%m/%%Y') as fecha_ingreso from usuarios, categorias, activos where activos.id_usuario=usuarios.id_usuario && activos.id_cat=categorias.id_cat && id_activo=%s",
				parent::comillas_inteligentes($_GET["id_activo"])
			);
			$res=mysql_query($sql,parent::con());
			if(mysql_affected_rows() > 0)
			{
				while($reg=mysql_fetch_assoc($res))//para recorrer los valores
				{
					$this->get_activo_por_id[]=$reg;
				}
				return $this->get_activo_por_id;
			}
			else
			{
					echo "<script type='text/javascript'>
					alert('Codigo no esta encontrado en la base de datos');
					window.location='".Conectar::ruta().".?accion=view_activo';
					</script>";
			}
		}
		else
		{
			echo "<script type='text/javascript'>
			alert('Codigo de usuario invalido');
			window.location='".Conectar::ruta().".?accion=view_activo';
			</script>";
		}
	}

	public function edit_activo()
	{
		if(empty($_POST["codigo_activo"]) or empty($_POST["nombre_activo"]) or empty($_POST["detalle_activo"]) or empty($_POST["cantidad_activo"]) or empty($_POST["precio_activo"]))
		{
			header("Location: ".Conectar::ruta()."?accion=edit_activo&m=5&id_activo=".$_POST["id_activo"]);
			exit;
		}

		//Validando que codigo de activo no repita
		$id_act = $_GET["id_activo"];
		parent::con();
		$sql=sprintf
		(
			"select * from activos where codigo_activo=%s and id_activo!='$id_act'",
			parent::comillas_inteligentes($_POST["codigo_activo"])
		);
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0)
		{
			/*1er caso: No se cambia ubicacion de activo ni foto de activo*/
			if(empty($_FILES["ubicacion_activo"]["name"]) and empty($_FILES["foto_activo"]["name"]))
			{
				$ubicacion_activo=$_POST["ubicacion_activo"];
				$foto_activo=$_POST["foto_activo"];

				//formateando fecha
                $fecha_ingreso=$_POST["fecha_ingreso"];
                $arreglo_fecha = explode("/", $fecha_ingreso);
                $nueva_fecha_ingreso = $arreglo_fecha['2']."-".$arreglo_fecha['1']."-".$arreglo_fecha['0'];

				//consulta para editar los valores
				$sql=sprintf
				(
					"update activos set codigo_activo=%s, nombre_activo=%s, fecha_ingreso='$nueva_fecha_ingreso', detalle_activo=%s, cantidad_activo=%s, tipo_activo=%s, precio_activo=%s, id_usuario=%s, vida_util=%s, id_cat=%s where id_activo=%s",
						parent::comillas_inteligentes($_POST["codigo_activo"]),
						parent::comillas_inteligentes($_POST["nombre_activo"]),
						parent::comillas_inteligentes($_POST["detalle_activo"]),
						parent::comillas_inteligentes($_POST["cantidad_activo"]),
						parent::comillas_inteligentes($_POST["tipo_activo"]),
						parent::comillas_inteligentes($_POST["precio_activo"]),
						parent::comillas_inteligentes($_POST["personal_activo"]),
						parent::comillas_inteligentes($_POST["vida_util"]),
						parent::comillas_inteligentes($_POST["categoria_activo"]),
						parent::comillas_inteligentes($_POST["id_activo"])
				);

					mysql_query($sql);

					header("Location: ".Conectar::ruta()."?accion=edit_activo&m=3&id_activo=".$_POST["id_activo"]); //se le redirecciona al usuario
			}
			else//sino esta vacio la volvemos a subir casi con el mismo proceso
			{
				//2do caso: Si no subira otra foto de ubicacion entonces subira otra foto de activo
				if(empty($_FILES["ubicacion_activo"]["name"]))
				{
					if($_FILES["foto_activo"]["type"]=="image/jpeg")
					{
						if($_FILES["foto_activo"]["size"] < 2097152)
						{
						//formateando fecha
		                $fecha_ingreso=$_POST["fecha_ingreso"];
		                $arreglo_fecha = explode("/", $fecha_ingreso);
		                $nueva_fecha_ingreso = $arreglo_fecha['2']."-".$arreglo_fecha['1']."-".$arreglo_fecha['0'];
							//Eliminando foto actual
							$query=sprintf
							(
								"select foto_activo from activos where id_activo=%s",
								parent::comillas_inteligentes($_POST["id_activo"])
							);
							$res=mysql_query($query);
							if($reg=mysql_fetch_array($res))
							{
									unlink("activos/".$reg["foto_activo"]);
							}
							//Subiendo otra foto
							$foto_activo=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto_activo"]["name"];
							$foto_activoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto_activo"]["name"]);
							copy($_FILES["foto_activo"]["tmp_name"],"activos/$foto_activoutf");
							$query=sprintf
							(
								"update activos set codigo_activo=%s, nombre_activo=%s, fecha_ingreso='$nueva_fecha_ingreso', detalle_activo=%s, cantidad_activo=%s, tipo_activo=%s, precio_activo=%s, foto_activo='$foto_activo', id_usuario=%s, vida_util=%s, id_cat=%s where id_activo=%s",
									parent::comillas_inteligentes($_POST["codigo_activo"]),
									parent::comillas_inteligentes($_POST["nombre_activo"]),
									parent::comillas_inteligentes($_POST["detalle_activo"]),
									parent::comillas_inteligentes($_POST["cantidad_activo"]),
									parent::comillas_inteligentes($_POST["tipo_activo"]),
									parent::comillas_inteligentes($_POST["precio_activo"]),
									parent::comillas_inteligentes($_POST["personal_activo"]),
									parent::comillas_inteligentes($_POST["vida_util"]),
									parent::comillas_inteligentes($_POST["categoria_activo"]),
									parent::comillas_inteligentes($_POST["id_activo"])
							);
							mysql_query($query);
							header("Location: ".Conectar::ruta()."?accion=edit_activo&m=3&id_activo=".$_POST["id_activo"]);
						}
						else// La foto no debe exceder los 2 mb
						{
							header("Location: ".Conectar::ruta()."?accion=edit_activo&m=1&id_activo=".$_POST["id_activo"]);
						}
					}
					else
					{
						header("Location: ".Conectar::ruta()."?accion=edit_activo&m=2&id_activo=".$_POST["id_activo"]); //se le redirecciona al usuario si la foto no es JPG
					}
				}

				//3er caso: Si no subira otra foto de activo entonces subira otra foto de ubicacion
				if(empty($_FILES["foto_activo"]["name"]))
				{
					if($_FILES["ubicacion_activo"]["type"]=="image/jpeg")
					{
						if($_FILES["ubicacion_activo"]["size"] < 2097152)
						{
							//formateando fecha
			                $fecha_ingreso=$_POST["fecha_ingreso"];
			                $arreglo_fecha = explode("/", $fecha_ingreso);
			                $nueva_fecha_ingreso = $arreglo_fecha['2']."-".$arreglo_fecha['1']."-".$arreglo_fecha['0'];
							//Eliminando foto actual
							$query=sprintf
							(
								"select ubicacion_activo from activos where id_activo=%s",
								parent::comillas_inteligentes($_POST["id_activo"])
							);
							$res=mysql_query($query);
							if($reg=mysql_fetch_array($res))
							{
									unlink("ubicaciones/".$reg["ubicacion_activo"]);
							}
							//Subiendo otra foto
							$ubicacion_activo=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["ubicacion_activo"]["name"];
							$ubicacion_activoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["ubicacion_activo"]["name"]);
							copy($_FILES["ubicacion_activo"]["tmp_name"],"ubicaciones/$ubicacion_activoutf");
							$query=sprintf
							(
								"update activos set codigo_activo=%s, nombre_activo=%s, fecha_ingreso='$nueva_fecha_ingreso', detalle_activo=%s, cantidad_activo=%s, tipo_activo=%s, precio_activo=%s, ubicacion_activo='$ubicacion_activo', id_usuario=%s, vida_util=%s, id_cat=%s where id_activo=%s",
									parent::comillas_inteligentes($_POST["codigo_activo"]),
									parent::comillas_inteligentes($_POST["nombre_activo"]),
									parent::comillas_inteligentes($_POST["detalle_activo"]),
									parent::comillas_inteligentes($_POST["cantidad_activo"]),
									parent::comillas_inteligentes($_POST["tipo_activo"]),
									parent::comillas_inteligentes($_POST["precio_activo"]),
									parent::comillas_inteligentes($_POST["personal_activo"]),
									parent::comillas_inteligentes($_POST["vida_util"]),
									parent::comillas_inteligentes($_POST["categoria_activo"]),
									parent::comillas_inteligentes($_POST["id_activo"])
							);
							mysql_query($query);
							header("Location: ".Conectar::ruta()."?accion=edit_activo&m=3&id_activo=".$_POST["id_activo"]);
						}
						else// La foto no debe exceder los 2 mb
						{
							header("Location: ".Conectar::ruta()."?accion=edit_activo&m=1&id_activo=".$_POST["id_activo"]);
						}
					}
					else
					{
						header("Location: ".Conectar::ruta()."?accion=edit_activo&m=2&id_activo=".$_POST["id_activo"]); //se le redirecciona al usuario si la foto no es JPG
					}
				}

				//4to caso: Que tiene q cambiar tanto foto activo como foto de la ubicacion de activo
				if(!empty($_FILES["ubicacion_activo"]["name"]) and !empty($_FILES["foto_activo"]["name"]))
				{
					if($_FILES["ubicacion_activo"]["type"]=="image/jpeg" and $_FILES["foto_activo"]["type"]=="image/jpeg")
					{
						if($_FILES["ubicacion_activo"]["size"] < 2097152 and $_FILES["foto_activo"]["size"] < 2097152)
						{
							//formateando fecha
			                $fecha_ingreso=$_POST["fecha_ingreso"];
			                $arreglo_fecha = explode("/", $fecha_ingreso);
			                $nueva_fecha_ingreso = $arreglo_fecha['2']."-".$arreglo_fecha['1']."-".$arreglo_fecha['0'];
							//Eliminando foto actual
							$query=sprintf
							(
								"select ubicacion_activo, foto_activo from activos where id_activo=%s",
								parent::comillas_inteligentes($_POST["id_activo"])
							);
							$res=mysql_query($query);
							if($reg=mysql_fetch_array($res))
							{
									unlink("ubicaciones/".$reg["ubicacion_activo"]);
									unlink("activos/".$reg["foto_activo"]);
							}
							//Subiendo otra foto de ubicacion de activo
							$ubicacion_activo=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["ubicacion_activo"]["name"];
							$ubicacion_activoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["ubicacion_activo"]["name"]);
							copy($_FILES["ubicacion_activo"]["tmp_name"],"ubicaciones/$ubicacion_activoutf");
							//Subiendo otra foto activo
							$foto_activo=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto_activo"]["name"];
							$foto_activoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto_activo"]["name"]);
							copy($_FILES["foto_activo"]["tmp_name"],"activos/$foto_activoutf");
							$query=sprintf
							(
								"update activos set codigo_activo=%s, nombre_activo=%s, fecha_ingreso='$nueva_fecha_ingreso', detalle_activo=%s, cantidad_activo=%s, tipo_activo=%s, precio_activo=%s, ubicacion_activo='$ubicacion_activo', foto_activo='$foto_activo', id_usuario=%s, vida_util=%s, id_cat=%s where id_activo=%s",
									parent::comillas_inteligentes($_POST["codigo_activo"]),
									parent::comillas_inteligentes($_POST["nombre_activo"]),
									parent::comillas_inteligentes($_POST["detalle_activo"]),
									parent::comillas_inteligentes($_POST["cantidad_activo"]),
									parent::comillas_inteligentes($_POST["tipo_activo"]),
									parent::comillas_inteligentes($_POST["precio_activo"]),
									parent::comillas_inteligentes($_POST["personal_activo"]),
									parent::comillas_inteligentes($_POST["vida_util"]),
									parent::comillas_inteligentes($_POST["categoria_activo"]),
									parent::comillas_inteligentes($_POST["id_activo"])
							);
							mysql_query($query);
							header("Location: ".Conectar::ruta()."?accion=edit_activo&m=3&id_activo=".$_POST["id_activo"]);
						}
						else// La foto no debe exceder los 2 mb
						{
							header("Location: ".Conectar::ruta()."?accion=edit_activo&m=1&id_activo=".$_POST["id_activo"]);
						}
					}
					else
					{
						header("Location: ".Conectar::ruta()."?accion=edit_activo&m=2&id_activo=".$_POST["id_activo"]); //se le redirecciona al usuario si la foto no es JPG
					}
				}
			}
		}
		else // el codigo de usuario ya existe
		{
			header("Location: ".Conectar::ruta()."?accion=edit_activo&m=4&id_activo=".$_POST["id_activo"]);
		}
	}

	public function delete_activo()
	{
		parent::con();

		$query01=sprintf
		(
			"select mantenimientos.id_activo from mantenimientos where mantenimientos.id_activo=%s",
			parent::comillas_inteligentes($_GET["id_activo"])
		);
		$res01=mysql_query($query01);

		$query02=sprintf
		(
			"select problemas.id_activo from problemas where problemas.id_activo=%s",
			parent::comillas_inteligentes($_GET["id_activo"])
		);
		$res02=mysql_query($query02);

		if (mysql_num_rows($res01)==0 and mysql_num_rows($res02)==0)
		{
			if(isset($_GET["id_activo"]))
			{
				$query=sprintf
				(
					"select ubicacion_activo, foto_activo from activos where id_activo=%s",
					parent::comillas_inteligentes($_GET["id_activo"])
				);
				$res=mysql_query($query);
				//ahora lo borramos la foto
				if($reg=mysql_fetch_array($res))
				{
					unlink("ubicaciones/".$reg["ubicacion_activo"]);
					unlink("activos/".$reg["foto_activo"]);
				}

				//y finalmente borramos el registro de la base de datos
				$sql=sprintf
				(
					"delete from activos where id_activo=%s",
					parent::comillas_inteligentes($_GET["id_activo"])
				);
				mysql_query($sql);

				header("Location: ".Conectar::ruta()."?accion=view_activo&m=1");
				exit;

			}
			else
			{
				header("Location: ".Conectar::ruta()."?accion=view_activo&m=2");
				exit;
			}
		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=view_activo&m=3");
			exit;
		}
	}
}
?>