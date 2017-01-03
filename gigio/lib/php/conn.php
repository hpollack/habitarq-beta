<?php
/**
* 
*@author Hermann Pollack
*@copyright 2016
*/
class conectaBD {
	private $host = 'localhost';
	private $user = 'root';
	private $pass = 'hermann';
	private $bd = 'recabarius';
	private $ResultSet;
	private $conexion;	
	public function __construct(){
		$this->conexion = (mysql_connect($this->host, $this->user, $this->pass)) or die(mysql_error());
		mysql_select_db($this->bd,$this->conexion) or die (mysql_error());
	}
	
	public function insertData($tabla,$campos=null,$valores=""){
		$sep = "";
		$query = "INSERT INTO ".$tabla;
		if($campos!=null){
			$query .= "(";
			for ($i=0; $i < count($campos); $i++) { 
				$query .= $sep.$campos[$i];
				$sep =", ";
			}
			$query .= ") ";
		}
		$query .= " VALUES(";
		for ($i=0;$i < count($valores); $i++) { 
			if(is_string($valores[$i])){
				$query .= $sep."'".$valores[$i]."'";
			}else{
				$query .= $sep.$valores[$i];
			}
			$sep = ", ";
		}
		$query .= ");";
		$this->ResultSet++;
		$sql = mysql_query($query,$this->conexion);
		if(!$sql){
			$respuesta = "Error en la consulta: ".mysql_error();
			exit;
		}else{
			$respuesta = "Datos Agregados";
		}
		
	}
	public function updateData($tabla,$campos,$condicion){
		$sep = "";
		$query = "UPDATE ".$tabla." SET ";
		$keys = array_keys($campos);
		for ($i=0;$i < count($campos) ; $i++) { 
			if(is_string($campos[$keys[$i]])){
				$query .= $sep.$keys[$i]." = '".$campos[$keys[$i]]."'";
			}else{
				$query .= $sep.$keys[$i]." = ".$campos[$keys[$i]]."";
			}
			$sep .= ", ";
		}
		$query .= " WHERE ".$condicion.";";
		$this->ResultSet++;
		$sql = mysql_query($query,$this->conexion);
		if(!$sql){
			echo  "Error al actualizar: ".mysql_error();
			exit;
		}else{
			echo "Datos Actualizados";
		}
		
	}
	public function getResultSet(){
		return $this->ResultSet;
	}	
	public function __destruct(){
		mysql_close($this->conexion);
	}	
}

?>