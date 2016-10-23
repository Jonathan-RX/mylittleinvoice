<?php

/*
Gestion de base de donnée
Date : 12/2009
Dernière modification : 06/2015 -> Ajout de la config
Auteur: Jonathan RAVIX
Cette classe à pour but de simplifier l'accès à une base de donnée en utilisant une méthode de programmation proche de celle de wordpress.
Comment l'utiliser :
Avant de l'utiliser, il convient de définir les variables $host, $login, $password et basename en fonction de votre serveur et base de donnée.

Script d'exmple :
$mybd = new Bd;
$mybd->config('hote','utilisateur','mot de passe','base de donnée');
$mybd->update('matable', array('info'=>'Mon titre d\'information'), array('info'=>'My info'));
$tables = $mybd->get_results('SELECT * FROM matable');
print_r($tables);

echo '<br /><br />' . $tables[0]->info;

*/

class Bd{
	private $host = 'localhost';
	private $login = 'root';
	private $password = '';
	private $basename = 'test_poo';
	public $prefix = '';
	public $option_table = '';
	public function insert($table_name, $data){
		$insert_id = '';
		$insert_value = '';
		mysql_connect($this->host, $this->login, $this->password);
		mysql_select_db($this->basename);
		foreach($data as $id => $value){
		$id = addslashes($id);
		$value = addslashes($value);
			if($insert_id == ''){$insert_id .= '' . $id . '';}else{$insert_id .= ', ' . $id . '';}
			if($insert_value == ''){$insert_value .= '"' . $value . '"';}else{$insert_value .= ' ,"' . $value . '"';}
		}
		$mysql_query = 'INSERT INTO ' . $table_name. '(' . $insert_id . ') VALUES(' . $insert_value . ')';
		if(mysql_query($mysql_query)){
			return true;
		}else{
			return false;
		}
		mysql_close();
	}
	public function update($table_name, $data, $where){
		mysql_connect($this->host, $this->login, $this->password);
		mysql_select_db($this->basename);
		$insert_value = '';
		foreach($data as $id => $value){
		$id = addslashes($id);
		$value = addslashes($value);
			if($insert_value == ''){$insert_value .= $id . '="' . $value . '"';}else{$insert_value .= ', ' . $id . '="' . $value . '"';}
		}
		$where_insert = '';
		foreach($where as $id => $value){
			$id = addslashes($id);
			$value = addslashes($value);
			if($where_insert == ''){$where_insert .= $id . '="' . $value . '"';}else{$where_insert .= ' AND ' . $id . '="' . $value . '"';}
		}
		$mysql_query = 'UPDATE ' . $table_name. ' SET ' . $insert_value . ' WHERE ' . $where_insert . '';
		
		if(mysql_query($mysql_query)){
		return true;
		}else{
		return false;
		}
		mysql_close();
	}
	public function get_results($request){
		mysql_connect($this->host, $this->login, $this->password);
		mysql_select_db($this->basename);
		$results = mysql_query($request);
		$reponse = array();
		$counter = 0;
		while ($result = mysql_fetch_array($results)){
			$reponse[$counter] = new stdClass;
			foreach($result as $key => $value){
					$reponse[$counter]->$key = stripcslashes($value);
			}
			$counter++;
		}
		return $reponse;
		mysql_close();
	}
	public function query($query = ''){
		mysql_connect($this->host, $this->login, $this->password);
		mysql_select_db($this->basename);
		$results = mysql_query($query);
		return true;
		mysql_close();
	}
	public function get_option($name=''){
		$r = $this->get_results('SELECT * FROM ' . $this->option_table . ' WHERE option_name="' . $name . '"');
		if(is_array($r) AND !empty($r)){
			$reponse = $r[0]->option_value;	
		}elseif(isset($r)){
			$reponse = true;
		}else{
			$reponse = false;
		}
		return $reponse;
		mysql_close();
	}
	public function set_option($name='',$value=''){
		$r = $this->get_results('SELECT * FROM ' . $this->option_table . ' WHERE option_name="' . $name . '"');
		if(is_array($r) AND !empty($r)){
			if($this->update($this->option_table,array('option_value'=>$value),array('option_name'=>$name))){
				return true;
			}else{
				return false;
			}
		}else{
			if($this->insert($this->option_table,array('option_name'=>$name,'option_value'=>$value))){
				return true;
			}else{
				return false;
			}	
		}
	}
	public function test_connect($host = '', $login = '', $password = '', $basename = ''){
		if(mysql_connect($host, $login, $password)){
			if(mysql_select_db($basename)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function config($host,$login,$password,$basename,$prefix='',$option_table=''){
		$this->host = $host;
		$this->login = $login;
		$this->password = $password;
		$this->basename = $basename;
		$this->prefix = $prefix;
		$this->option_table = $option_table;
	}
}


?>