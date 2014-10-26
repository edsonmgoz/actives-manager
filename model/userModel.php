<?php
class Usuario extends Conectar
{
	private $nombre;
	private $usuario;
	private $get_perfil;
	private $perfil_por_id;
	private $get_usuario_por_ses;
	private $get_usuario_por_id;
	private $get_personal;
	private $get_usuario;

	public function add_user()
	{
		$pass_js=$_POST["pass"];
		$pass_php=md5($_POST["pass"]);

			if($_FILES["foto"]["type"]=="image/jpeg")
			{
				if($_FILES["foto"]["size"] < 2097152)
				{
					//Subiendo foto
					$foto=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto"]["name"];
					$fotoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto"]["name"]);
					copy($_FILES["foto"]["tmp_name"],"pics/$fotoutf");

					//Validando que login no se repita
					parent::con();
					$sql=sprintf
					(
						"select login from usuarios where login=%s",
						parent::comillas_inteligentes($_POST["user"])
					);
					$res=mysql_query($sql);
					if(mysql_num_rows($res)==0)
					{
						$query=sprintf
						(
							"insert into usuarios values (null,%s,%s,'$pass_js','$pass_php',%s,'habilitado','$foto',now());",
							parent::comillas_inteligentes($_POST["nombre"]),
							parent::comillas_inteligentes($_POST["user"]),
							parent::comillas_inteligentes($_POST["tipo"])
						);
						mysql_query($query);
						header("Location: ".Conectar::ruta()."?accion=add_user&m=3"); //Usuario ingresado correctamente
					}
					else
					{
						header("Location: ".Conectar::ruta()."?accion=add_user&m=4"); //Se le redirecciona si el login es repetido
					}
				}
				else// La foto no debe exceder los 2 mb
				{
					header("Location: ".Conectar::ruta()."?accion=add_user&m=1");
				}
			}
			else //solo jpg
			{
				header("Location: ".Conectar::ruta()."?accion=add_user&m=2");
			}
	}

	public function get_usuario()
	{
		$sql="select *, date_format(fecha_usuario,'%d-%m-%Y') as fecha_usuario from usuarios where tipo_usuario != 'administrador' order by id_usuario desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_usuario[]=$reg;
		}
		return $this->get_usuario;
	}

	public function get_usuario_por_id()
	{
		if(isset($_GET['id_usuario']) and $_GET['id_usuario'] > 0)
		{
			parent::con();
			$sql=sprintf
			(
				"select * from usuarios where id_usuario=%s",
				parent::comillas_inteligentes($_GET["id_usuario"])
			);
			$res=mysql_query($sql,parent::con());
			if(mysql_affected_rows() > 0)
			{
				while($reg=mysql_fetch_assoc($res))//para recorrer los valores
				{
					$this->get_usuario_por_id[]=$reg;
				}
				return $this->get_usuario_por_id;
			}
			else
			{
					echo "<script type='text/javascript'>
					alert('Codigo no esta encontrado en la base de datos');
					window.location='".Conectar::ruta().".?accion=view_user';
					</script>";

			}
		}
		else
		{
			echo "<script type='text/javascript'>
			alert('Codigo de usuario invalido');
			window.location='".Conectar::ruta().".?accion=view_user';
			</script>";
		}
	}

	public function get_personal()
	{
		$sql="select id_usuario, nombre_usuario from usuarios where tipo_usuario = 'personal' order by id_usuario desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_personal[]=$reg;
		}
		return $this->get_personal;
	}

	public function edit_user()
	{
		if(empty($_POST["nombre"]) or empty($_POST["user"]))
		{
			header("Location: ".Conectar::ruta()."?accion=edit_user&m=5&id_usuario=".$_POST["id_usuario"]);
			exit;
		}

		//Validando que login de usuario no repita
		$id_usu = $_GET["id_usuario"];
		parent::con();
		$sql=sprintf
		(
			"select * from usuarios where login=%s and id_usuario!='$id_usu'",
			parent::comillas_inteligentes($_POST["user"])
		);
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0)
		{
			if(empty($_FILES["foto"]["name"]))//si el valor de la foto esta vacio significa q el usuario se quedo con su foto y no lo modifico
			{
				$foto=$_POST["foto"];

				//consulta para editar los valores
				$sql=sprintf
				(
					"update usuarios set nombre_usuario=%s, login=%s, tipo_usuario=%s, fecha_usuario=now() where id_usuario=%s",
						parent::comillas_inteligentes($_POST["nombre"]),
						parent::comillas_inteligentes($_POST["user"]),
						parent::comillas_inteligentes($_POST["tipo"]),
						parent::comillas_inteligentes($_POST["id_usuario"])
				);

					mysql_query($sql);

					header("Location: ".Conectar::ruta()."?accion=edit_user&m=3&id_usuario=".$_POST["id_usuario"]); //se le redirecciona al usuario
			}
			else//sino esta vacio la volvemos a subir casi con el mismo proceso
			{
				if($_FILES["foto"]["type"]=="image/jpeg")
				{
					if($_FILES["foto"]["size"] < 2097152)
					{
						//Eliminando foto actual
						$query=sprintf
						(
							"select foto from usuarios where id_usuario=%s",
							parent::comillas_inteligentes($_POST["id_usuario"])
						);
						$res=mysql_query($query);
						if($reg=mysql_fetch_array($res))
						{
								unlink("pics/".$reg["foto"]);
						}
						//Subiendo otra foto
						$foto=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto"]["name"];
						$fotoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto"]["name"]);
						copy($_FILES["foto"]["tmp_name"],"pics/$fotoutf");
						$query=sprintf
						(
							"update usuarios set nombre_usuario=%s, login=%s, tipo_usuario=%s, foto='$foto', fecha_usuario=now() where id_usuario=%s",

							parent::comillas_inteligentes($_POST["nombre"]),
							parent::comillas_inteligentes($_POST["user"]),
							parent::comillas_inteligentes($_POST["tipo"]),
							parent::comillas_inteligentes($_POST["id_usuario"])
						);
						mysql_query($query);
						header("Location: ".Conectar::ruta()."?accion=edit_user&m=3&id_usuario=".$_POST["id_usuario"]);
					}
					else// La foto no debe exceder los 2 mb
					{
						header("Location: ".Conectar::ruta()."?accion=edit_user&m=1&id_usuario=".$_POST["id_usuario"]);
					}
				}
				else
				{
					header("Location: ".Conectar::ruta()."?accion=edit_user&m=2&id_usuario=".$_POST["id_usuario"]); //se le redirecciona al usuario si la foto no es JPG
				}
			}
		}
		else // el login de usuario ya existe
		{
			header("Location: ".Conectar::ruta()."?accion=edit_user&m=4&id_usuario=".$_POST["id_usuario"]);
		}
	}

	public function delete_user()
	{
		parent::con();
		$query01=sprintf
		(
			"select activos.id_usuario from activos where activos.id_usuario=%s",
			parent::comillas_inteligentes($_GET["id_usuario"])
		);
		$res01=mysql_query($query01);

		$query02=sprintf
		(
			"select mantenimientos.id_usuario from mantenimientos where mantenimientos.id_usuario=%s",
			parent::comillas_inteligentes($_GET["id_usuario"])
		);
		$res02=mysql_query($query02);

		$query03=sprintf
		(
			"select problemas.id_usuario from problemas where problemas.id_usuario=%s",
			parent::comillas_inteligentes($_GET["id_usuario"])
		);
		$res03=mysql_query($query03);

		if (mysql_num_rows($res01)==0 and mysql_num_rows($res02)==0 and mysql_num_rows($res03)==0) {
			if(isset($_GET["id_usuario"]))
			{
				$query=sprintf
				(
					"select foto from usuarios where id_usuario=%s",
					parent::comillas_inteligentes($_GET["id_usuario"])
				);
				$res=mysql_query($query);
				//ahora lo borramos la foto
				if($reg=mysql_fetch_array($res))
				{
					unlink("pics/".$reg["foto"]);
				}

				//Borrando el registro
				$sql=sprintf
				(
					"delete from usuarios where id_usuario=%s",
					parent::comillas_inteligentes($_GET["id_usuario"])
				);
				mysql_query($sql);

				header("Location: ".Conectar::ruta()."?accion=view_user&m=1");
				exit;

			}
			else
			{
				header("Location: ".Conectar::ruta()."?accion=view_user&m=2");
				exit;
			}
		}
		else
		{
			header("Location: ".Conectar::ruta()."?accion=view_user&m=3");
			exit;
		}
	}

	public function cambiar_pass()
	{
		$pass_js=$_POST["pass"];
		$pass_php=md5($_POST["pass"]);

		$pass_actual_js = $_POST["pass_actual"];
		$pass_actual_php = md5($_POST["pass_actual"]);

		$id_usu = $_GET["id_usuario"];
		$id_admin = $_SESSION["ses_id"];
		parent::con();
		$sql=sprintf
		(
			"select * from usuarios where pass_js='$pass_actual_js' and pass_php='$pass_actual_php' and id_usuario = '$id_admin'"
		);
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0)
		{
			header("Location: ".Conectar::ruta()."?accion=cambiar_pass&m=4&id_usuario=".$_POST["id_usuario"]);
			exit;
		}
		else
		{
			parent::con();
			$sql=sprintf
			(
				"update usuarios set pass_js='$pass_js', pass_php='$pass_php' where id_usuario=%s",
				parent::comillas_inteligentes($_GET["id_usuario"])
			);
			mysql_query($sql);
			header("Location: ".Conectar::ruta()."?accion=cambiar_pass&m=3&id_usuario=".$_POST["id_usuario"]);
		}
	}

	public function cambiarpass_admin()
	{
		$pass_js=$_POST["pass"];
		$pass_php=md5($_POST["pass"]);

		$pass_actual_js = $_POST["pass_actual"];
		$pass_actual_php = md5($_POST["pass_actual"]);

		$id_usu = $_GET["id_usuario"];
		$id_admin = $_SESSION["ses_id"];
		parent::con();
		$sql=sprintf
		(
			"select * from usuarios where pass_js='$pass_actual_js' and pass_php='$pass_actual_php' and id_usuario = '$id_admin'"
		);
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0)
		{
			header("Location: ".Conectar::ruta()."?accion=cambiarpass_admin&m=4&id_usuario=".$_POST["id_usuario"]);
			exit;
		}
		else
		{
			parent::con();
			$sql=sprintf
			(
				"update usuarios set pass_js='$pass_js', pass_php='$pass_php' where id_usuario=%s",
				parent::comillas_inteligentes($_GET["id_usuario"])
			);
			mysql_query($sql);
			header("Location: ".Conectar::ruta()."?accion=cambiarpass_admin&m=3&id_usuario=".$_POST["id_usuario"]);
		}
	}

	public function get_perfil()
	{
		$ses = $_SESSION["ses_id"];
		$sql="select id_usuario, nombre_usuario, login, estado from usuarios where id_usuario = $ses";
		$res=mysql_query($sql,parent::con());
		if(mysql_num_rows($res)==0)
		{
			header("Location: ".Conectar::ruta()."?accion=perfil_admin&m=1");
			exit;
		}
		else
		{
			while($reg=mysql_fetch_assoc($res))
			{
				$this->get_perfil[]=$reg;
			}
			return $this->get_perfil;
		}
	}

	public function cambiar_estado()
	{
		parent::con();
		$sql=sprintf
		(
			"update usuarios set estado=%s where id_usuario=%s",
			parent::comillas_inteligentes($_GET["bandera"]),
			parent::comillas_inteligentes($_GET["id_usuario"])
		);
		mysql_query($sql);
		header("Location: ".Conectar::ruta()."?accion=view_user");
	}

	public function get_usuario_por_ses()
	{
		$ses_usu = $_SESSION['ses_id'];
		parent::con();
		$sql=sprintf
		(
			"select * from usuarios where id_usuario='$ses_usu'"
		);
		$res=mysql_query($sql);
		if(mysql_affected_rows() > 0)
		{
			while($reg=mysql_fetch_assoc($res))
			{
				$this->perfil_por_id[]=$reg;
			}
			return $this->perfil_por_id;
		}
		else
		{
			echo "<script type='text/javascript'>
			alert('Código de usuario no encontrado en la base de datos');
			window.location='".Conectar::ruta().".?accion=index';
			</script>";
		}
	}

	public function edit_perfil()
	{
		if(empty($_POST["nombre"]) or empty($_POST["login"]))
		{
			header("Location: ".Conectar::ruta()."?accion=editperfil&m=1&id_usuario=".$_POST["id_usuario"]);
			exit;
		}
		//Validando que login de usuario no repita
		$id_usu = $_GET["id_usuario"];
		parent::con();
		$sql=sprintf
		(
			"select * from usuarios where login=%s and id_usuario!='$id_usu'",
			parent::comillas_inteligentes($_POST["login"])
		);
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0)
		{
			parent::con();
			$sql=sprintf
			(
				"update usuarios set nombre_usuario=%s, login=%s where id_usuario=%s",
				parent::comillas_inteligentes($_POST["nombre"]),
				parent::comillas_inteligentes($_POST["login"]),
				parent::comillas_inteligentes($_POST["id_usuario"])
			);
			mysql_query($sql);
			header("Location: ".Conectar::ruta()."?accion=editperfil&m=2&id_usuario=".$_POST["id_usuario"]); //Archivo editado con exito
		}
		else // el login de usuario ya existe
		{
			header("Location: ".Conectar::ruta()."?accion=editperfil&m=3&id_usuario=".$_POST["id_usuario"]);
		}
	}



	public function salir()
	{
		session_destroy();
		header("Location: ".Conectar::ruta()."?accion=index&m=3");
		exit;
	}

	public function logueo()
	{
		$pass_js=$_POST["pass"];
		$pass_php=md5($_POST["pass"]);

		if(empty($_POST["login"]) or empty($_POST["pass"]))
		{
			header("Location: ".Conectar::ruta()."?accion=logueo&m=1");
			exit;
		}
		parent::con();
		$sql=sprintf
		(
			"select id_usuario, tipo_usuario, estado from usuarios where login=%s and pass_js='$pass_js' and pass_php='$pass_php'",
			parent::comillas_inteligentes($_POST["login"])
		);
		$res=mysql_query($sql);
		if(mysql_num_rows($res)==0)
		{
			header("Location: ".Conectar::ruta()."?accion=logueo&m=2");
			exit;
		}
		else
		{
			if($reg=mysql_fetch_array($res))
			{
				$privilegio = $reg['tipo_usuario'];
				$estado = $reg['estado'];
				if($privilegio=="encargado" and $estado=="habilitado")
				{
					$_SESSION["ses_id"]=$reg["id_usuario"];
					$_SESSION["privilegio"]='encargado';
					header("Location: ".Conectar::ruta()."?accion=encargado");
				}
				else if($privilegio=="personal" and $estado=="habilitado")
				{
					$_SESSION["ses_id"]=$reg["id_usuario"];
					$_SESSION["privilegio"]='personal';
					header("Location: ".Conectar::ruta()."?accion=personal");
				}
				else if($privilegio=="administrador" and $estado=="habilitado")
				{
					$_SESSION["ses_id"]=$reg["id_usuario"];
					$_SESSION["privilegio"]='administrador';
					header("Location: ".Conectar::ruta()."?accion=administrador");
				}
				else
				{
					header("Location: ".Conectar::ruta()."?accion=index&m=4");
					exit;
				}
			}
		}
	}

	public function cambiar_foto()
	{
		if(empty($_FILES["foto"]["name"]))
		{
			header("Location: ".Conectar::ruta()."?accion=cambiarfoto&m=4&id_usuario=".$_POST["id_usuario"]);
			exit;
		}
		else
		{
			if($_FILES["foto"]["type"]=="image/jpeg")
			{
				if($_FILES["foto"]["size"] < 2097152)
				{
					//Eliminando foto actual
					parent::con();
					$query=sprintf
					(
						"select foto from usuarios where id_usuario=%s",
						parent::comillas_inteligentes($_POST["id_usuario"])
					);
					$res=mysql_query($query);
					if($reg=mysql_fetch_array($res))
					{
							unlink("pics/".$reg["foto"]);
					}
					//Subiendo otra foto
					$foto=date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto"]["name"];
					$fotoutf=utf8_decode(date("d-m-Y")."_".date("h-i-s")."_".$_FILES["foto"]["name"]);
					copy($_FILES["foto"]["tmp_name"],"pics/$fotoutf");
					$query=sprintf
					(
						"update usuarios set foto='$foto' where id_usuario=%s",
						parent::comillas_inteligentes($_POST["id_usuario"])
					);
					mysql_query($query);
					header("Location: ".Conectar::ruta()."?accion=cambiarfoto&m=1&id_usuario=".$_POST["id_usuario"]);
				}
				else// La foto no debe exceder los 2 mb
				{
					header("Location: ".Conectar::ruta()."?accion=cambiarfoto&m=2&id_usuario=".$_POST["id_usuario"]);
				}
			}
			else //solo jpg
			{
				header("Location: ".Conectar::ruta()."?accion=cambiarfoto&m=3&id_usuario=".$_POST["id_usuario"]);
			}
		}
	}

	public function saluda_al_usuario($id_usuario)
	{
		$sql="select nombre_usuario from usuarios where id_usuario=$id_usuario";
		$res=mysql_query($sql,Conectar::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->nombre[]=$reg;
		}
		return $this->nombre;
	}

	public function control_de_acceso()
	{
		if(!isset($_SESSION["ses_id"]))
		{
			header("Location: ".Conectar::ruta()."?accion=index&m=4");
			exit;
		}
	}

	public function control_de_sesion_admin()
	{
		if(isset($_SESSION['privilegio']) and $_SESSION['privilegio'] != 'administrador')
		{
			if($_SESSION['privilegio'] == 'encargado')
			{
				header("Location: ".Conectar::ruta()."?accion=encargado&m=1");
				exit;
			}
			elseif($_SESSION['privilegio'] == 'personal')
			{
				header("Location: ".Conectar::ruta()."?accion=personal&m=1");
				exit;
			}
		}
		if(!isset($_SESSION["ses_id"]))
		{
				header("Location: ".Conectar::ruta()."?accion=logueo&m=3");
				exit;
		}
	}

	public function control_de_sesion_encargado()
	{
		if(isset($_SESSION['privilegio']) and $_SESSION['privilegio'] != 'encargado')
		{
			if($_SESSION['privilegio'] == 'administrador')
			{
				header("Location: ".Conectar::ruta()."?accion=administrador");
				exit;
			}
			elseif($_SESSION['privilegio'] == 'personal')
			{
				header("Location: ".Conectar::ruta()."?accion=personal&m=1");
				exit;
			}

		}
		if(!isset($_SESSION["ses_id"]))
		{
				header("Location: ".Conectar::ruta()."?accion=logueo&m=3");
				exit;
		}
	}

	public function control_de_sesion_personal()
	{
		if(isset($_SESSION['privilegio']) and $_SESSION['privilegio'] != 'personal')
		{
			if($_SESSION['privilegio'] == 'administrador')
			{
				header("Location: ".Conectar::ruta()."?accion=administrador");
				exit;
			}
			elseif($_SESSION['privilegio'] == 'encargado')
			{
				header("Location: ".Conectar::ruta()."?accion=encargado&m=1");
				exit;
			}

		}
		if(!isset($_SESSION["ses_id"]))
		{
				header("Location: ".Conectar::ruta()."?accion=logueo&m=3");
				exit;
		}
	}
}
?>