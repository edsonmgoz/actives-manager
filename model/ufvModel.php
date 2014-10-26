<?php
class Ufv extends Conectar
{
	/* Generar UFVs de 10 años
	public function generar()
	{
		$j=1.90027;
		for ($i=0; $i < 3650 ; $i++)
		{
			$fecha = strtotime("2014-01-01")+(60*60*24*$i);
			$fecha_sum = date("Y-m-d",$fecha);
			parent::con();
			$query=sprintf
			(
				"insert into ufvs values (null, '$j', '$fecha_sum');"
			);
			mysql_query($query);
			$j=$j+0.00032;
		}
	}
	*/
	private $verifica;
	private $get_enero;
	private $get_febrero;
	private $get_marzo;
	private $get_abril;
	private $get_mayo;
	private $get_junio;
	private $get_julio;
	private $get_agosto;
	private $get_septiembre;
	private $get_octubre;
	private $get_noviembre;
	private $get_diciembre;
	private $ufv_final;
	private $ufv_inicial;
	private $get_ufv;

	public function verifica()
	{
		$fecha = date("Y");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->verifica[]=$reg;
		}
		return $this->verifica;
	}
	public function get_enero()
	{
		$fecha = date("Y");
		$mes = date("01");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_enero[]=$reg;
		}
		return $this->get_enero;
	}

	public function get_febrero()
	{
		$fecha = date("Y");
		$mes = date("02");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_febrero[]=$reg;
		}
		return $this->get_febrero;
	}

	public function get_marzo()
	{
		$fecha = date("Y");
		$mes = date("03");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_marzo[]=$reg;
		}
		return $this->get_marzo;
	}

	public function get_abril()
	{
		$fecha = date("Y");
		$mes = date("04");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_abril[]=$reg;
		}
		return $this->get_abril;
	}

	public function get_mayo()
	{
		$fecha = date("Y");
		$mes = date("05");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_mayo[]=$reg;
		}
		return $this->get_mayo;
	}

	public function get_junio()
	{
		$fecha = date("Y");
		$mes = date("06");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_junio[]=$reg;
		}
		return $this->get_junio;
	}

	public function get_julio()
	{
		$fecha = date("Y");
		$mes = date("07");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_julio[]=$reg;
		}
		return $this->get_julio;
	}

	public function get_agosto()
	{
		$fecha = date("Y");
		$mes = date("08");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_agosto[]=$reg;
		}
		return $this->get_agosto;
	}

	public function get_septiembre()
	{
		$fecha = date("Y");
		$mes = date("09");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_septiembre[]=$reg;
		}
		return $this->get_septiembre;
	}

	public function get_octubre()
	{
		$fecha = date("Y");
		$mes = date("10");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_octubre[]=$reg;
		}
		return $this->get_octubre;
	}

	public function get_noviembre()
	{
		$fecha = date("Y");
		$mes = date("11");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_noviembre[]=$reg;
		}
		return $this->get_noviembre;
	}

	public function get_diciembre()
	{
		$fecha = date("Y");
		$mes = date("12");
		$sql="select * from ufvs where '$fecha' = YEAR(fecha_ufv) && '$mes' = MONTH(fecha_ufv) order by id_ufv asc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_diciembre[]=$reg;
		}
		return $this->get_diciembre;
	}

	// public function ufv_inicial()
	// {
	// 	$anio = date("Y");
	// 	$sql="select valor_ufv from ufvs where fecha_ufv = '$anio-01-01'";
	// 	$res=mysql_query($sql,parent::con());
	// 	while($reg=mysql_fetch_assoc($res))
	// 	{
	// 		$this->ufv_inicial[]=$reg;
	// 	}
	// 	return $this->ufv_inicial;
	// }


	// public function ufv_final()
	// {
	// 	$anio = date("Y");
	// 	$sql="select valor_ufv from ufvs where fecha_ufv = '$anio-12-31'";
	// 	$res=mysql_query($sql,parent::con());
	// 	while($reg=mysql_fetch_assoc($res))
	// 	{
	// 		$this->ufv_final[]=$reg;
	// 	}
	// 	return $this->ufv_final;
	// }


	public function get_ufv()
	{
		$sql="select valor_ufv, fecha_ufv from ufvs";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_ufv[]=$reg;
		}
		return $this->get_ufv;
	}
}
?>