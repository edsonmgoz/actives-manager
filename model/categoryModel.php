<?php
class Category extends Conectar
{
	private $get_category;
	public function get_category()
	{
		$sql="select * from categorias order by id_cat desc";
		$res=mysql_query($sql,parent::con());
		while($reg=mysql_fetch_assoc($res))
		{
			$this->get_category[]=$reg;
		}
		return $this->get_category;
	}
}
?>