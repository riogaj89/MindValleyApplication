<?php

session_start();
require_once 'db.php';
$sql = db::getInstance();

class Shortener{	

	protected function generateCode($num){
		return base_convert($num, 10, 36);
	}

	public function makeCode($url){
		$url = trim($url);

		if(!filter_var($url, FILTER_VALIDATE_URL)){
			return '';
		}
		$sql = db::getInstance();
		//$url = $sql->mysql_escape_string($url);
					
		//Check if URL Exist
		$exist = $sql->query("SELECT code FROM links WHERE url = '{$url}'");

		if($exist->num_rows){
			return $exist->fetch_object()->code;			
		}else{
			//Insert record without a code
			$insert = $sql->query("INSERT INTO links (url, created) VALUES ('{$url}', NOW())");

			// Generate a code based on inserted ID
			$code = $this->generateCode($sql->insert_id);

			// Update record with the generated code
			$sql->query("UPDATE links SET code = '{$code}' WHERE url = '{$url}'");

			return $code;
		}

	}

	public function getUrl($code){
		
		$sql = db::getInstance();
		//$code = mysql_escape_string($sql, $code);
		$code = $sql->query("SELECT url FROM links WHERE code = '{$code}'");

		if ($code->num_rows){
			return $code->fetch_object()->url;
		}

		return '';
	}
}