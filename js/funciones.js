function validar_logueo()
{
	var form=document.form;
	if (form.login.value==0)
	{
		alert("Ingrese su login");
		form.login.value="";
		form.login.focus();
		return false;
	}
	if (form.pass.value==0)
	{
		alert("Ingrese su password");
		form.pass.value="";
		form.pass.focus();
		return false;
	}
	form.pass.value=calcMD5(form.pass.value);

	form.submit();
}
function soloLetras(e)
{
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key).toLowerCase();
	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
	especiales = [8,9,37,39,46];
	tecla_especial = false
	for(var i in especiales){
		if(key == especiales[i]){
			tecla_especial = true;
			break;
		}
	}
	if(letras.indexOf(tecla)==-1 && !tecla_especial)
		return false;
}

function valida_usuario()
{
	var form=document.form;
	if (form.nombre.value==0)
	{
		alert("Ingrese su nombre completo");
		form.nombre.value="";
		form.nombre.focus();
		return false;
	}
	if (form.user.value==0)
	{
		alert("Ingrese su login");
		form.user.value="";
		form.user.focus();
		return false;
	}
	if (form.pass.value==0)
	{
		alert("Ingrese su password");
		form.pass.value="";
		form.pass.focus();
		return false;
	}
	if (form.pass_1.value==0)
	{
		alert("Repita el password");
		form.pass_1.value="";
		form.pass_1.focus();
		return false;
	}
	if (form.pass.value != form.pass_1.value)
	{
		alert("Los password ingresados no coinciden");
		form.pass.value="";
		form.pass_1.value="";
		form.pass.focus();
		return false;
	}

	if (form.tipo.selectedIndex==0){
       alert("Seleccione tipo de usuario.")
       document.form.tipo.focus()
       return 0;
    }

	if(form.foto.value==0)
	{
		alert("Seleccione una foto");
		form.foto.value="";
		form.foto.focus();
		return false;
	}

	form.pass.value=calcMD5(form.pass.value);
	form.pass_1.value=calcMD5(form.pass_1.value);
	form.submit();
}

function validar_activo()
{
	var form=document.form;
	if (form.codigo_activo.value==0)
	{
		alert("Ingrese código de activo");
		form.codigo_activo.value="";
		form.codigo_activo.focus();
		return false;
	}
	if (form.nombre_activo.value==0)
	{
		alert("Ingrese nombre de activo");
		form.nombre_activo.value="";
		form.nombre_activo.focus();
		return false;
	}
	if (form.categoria_activo.selectedIndex==0){
       alert("Seleccione categoría para el activo.")
       document.form.categoria_activo.focus()
       return 0;
    }
	if (form.detalle_activo.value==0)
	{
		alert("Ingrese detalle del activo");
		form.detalle_activo.value="";
		form.detalle_activo.focus();
		return false;
	}
	if (form.cantidad_activo.value==0)
	{
		alert("Ingrese cantidad");
		form.cantidad_activo.value="";
		form.cantidad_activo.focus();
		return false;
	}
	if (form.tipo_activo.selectedIndex==0){
       alert("Seleccione tipo de activo.")
       document.form.tipo_activo.focus()
       return 0;
    }
	if (form.precio_activo.value==0)
	{
		alert("Ingrese precio de activo");
		form.precio_activo.value="";
		form.precio_activo.focus();
		return false;
	}
	if(form.ubicacion_activo.value==0)
	{
		alert("Seleccione una imagen de la ubicación del activo");
		form.ubicacion_activo.value="";
		form.ubicacion_activo.focus();
		return false;
	}
	if(form.foto_activo.value==0)
	{
		alert("Seleccione una foto del activo");
		form.foto_activo.value="";
		form.foto_activo.focus();
		return false;
	}
	if (form.personal_activo.selectedIndex==0){
       alert("Seleccione a la persona encargada del activo.")
       document.form.personal_activo.focus()
       return 0;
    }
	//alert("Enviado");
	form.submit();
}

function validar_mantenimiento()
{
	var form=document.form;
	if (form.personal_activo.selectedIndex==0){
       alert("Seleccione a la persona encargada del mantenimiento.")
       document.form.personal_activo.focus()
       return 0;
    }
	if (form.fecha_inicio.value==0)
	{
		alert("Ingrese fecha inicio del mantenimiento");
		form.fecha_inicio.value="";
		form.fecha_inicio.focus();
		return false;
	}
	if (form.fecha_fin.value==0)
	{
		alert("Ingrese fecha fin del mantenimiento");
		form.fecha_fin.value="";
		form.fecha_fin.focus();
		return false;
	}
	if (form.mantenimiento_activo.selectedIndex==0){
       alert("Seleccione activo para el mantenimiento.")
       document.form.mantenimiento_activo.focus()
       return 0;
    }
    form.submit();
}

function validar_problema()
{
	var form=document.form;
	if (form.problema_activo.selectedIndex==0){
       alert("Seleccione activo.")
       document.form.problema_activo.focus()
       return 0;
    }
	if (form.detalle_problema.value==0)
	{
		alert("Ingrese detalle del problema.");
		form.detalle_problema.value="";
		form.detalle_problema.focus();
		return false;
	}
	if (form.fecha_problema.value==0)
	{
		alert("Ingrese fecha en la que se detectó el problema.");
		form.fecha_problema.value="";
		form.fecha_problema.focus();
		return false;
	}

    form.submit();
}

function tr(id,color)
{
	document.getElementById(id).style.backgroundColor=color;
}

function deshabilitar(ruta)
{
	if(confirm("Desea deshabilitar usuario ?"))
	{
		window.location=ruta;
	}
}
function habilitar(ruta)
{
	if(confirm("Desea habilitar usuario ?"))
	{
		window.location=ruta;
	}
}
function eliminar(ruta) //la funcion recibe la ruta
{
	if(confirm("Realmente desea eliminar este registro ?"))
	{
		window.location=ruta;
	}
}
function eliminar_asign(ruta)
{
	if(confirm("Eliminar asignación de mantenimiento ?"))
	{
		window.location=ruta;
	}
}
function concluir_mante(ruta) //la funcion recibe la ruta
{
	if(confirm("¿Mantenimiento concluido?"))
	{
		window.location=ruta;
	}
}
function sol_problem(ruta) //la funcion recibe la ruta
{
	if(confirm("¿Problema solucionado?"))
	{
		window.location=ruta;
	}
}
function cambiar_pass()
{
	var form=document.form;
	if (form.pass_actual.value==0)
	{
		alert("Ingrese password de administrador");
		form.pass_actual.value="";
		form.pass_actual.focus();
		return false;
	}
	if (form.pass.value==0)
	{
		alert("Ingrese el nuevo password del usuario");
		form.pass.value="";
		form.pass.focus();
		return false;
	}
	if (form.pass_1.value==0)
	{
		alert("Repita el nuevo password del usuario");
		form.pass_1.value="";
		form.pass_1.focus();
		return false;
	}
	if (form.pass.value != form.pass_1.value)
	{
		alert("Los password ingresados no coinciden");
		form.pass.value="";
		form.pass_1.value="";
		form.pass.focus();
		return false;
	}
	form.pass_actual.value=calcMD5(form.pass_actual.value);
	form.pass.value=calcMD5(form.pass.value);
	form.pass_1.value=calcMD5(form.pass_1.value);
	form.submit();
}