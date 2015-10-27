<?php
class database{

	var $database=NULL;
	var $querys="";
	var $resource=NULL;
	
	function database($host,$user,$pass){
		@$link=mysql_connect($host,$user,$pass) 
		or die("No se puede conectar a la base de datos en este  momento. Existe un error en el servidor de base de datos. ".$db);
		$this->database=&$link;
	}
	
	function setDb($db){
		mysql_select_db($db,$this->database);
	}
	
	function setquery($sql){
		$this->querys=$sql;
	}
	
	function query(){
		$id=&$this->database;
		$this->resource = mysql_query($this->querys,$id);
	}
	
	function loadObject(&$object){
		if ($cur = $this->resource){
			if ($object = mysql_fetch_object($cur)){
				mysql_free_result($cur);
				return true;
			}else{
				$object = null;
				return false;
			}
		}else{
			return false;
		}
	}
	
	function listObjects( $key=''){
		if (!($cur = $this->resource)){
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_object( $cur )){
			if($key){
				$array[$row->$key] = $row;
			}else{
				$array[] = $row;
			}
		}
		mysql_free_result( $cur );
		return $array;
	}

	function loadRow(){
		if(!($cur = $this->resource)){
			return null;
		}
		$ret = null;
		if($row = mysql_fetch_row( $cur )) {
			$ret = $row;
		}
		mysql_free_result( $cur );
		return $ret;
	}
	
	function loadRowList( $key='' ){
		if(!($cur = $this->resource)){
			return null;
		}
		$array = array();
		while ($row = mysql_fetch_row( $cur )){
		
			if ($key){
				$array[$row[$key]] = $row;
			}else{
				$array[] = $row;
			}
		}
		mysql_free_result( $cur );
		return $array;
	}
	
	function counterResult(){
		$contador = mysql_num_rows($this->resource);
		return $contador;
	}

	function close(){
		mysql_close($this->database);
	}
	
	function getParams($params){
		foreach($params as $p){
			$this->querys = str_replace("?",$p,$this->querys);
		}
	}

}
?>