<?php

class Shortener extends mysqli{
	public $db;

	public function _construct(){		//for demo purposes
		$this->db = mysqli_connect('localhost', 'root', '', 'website');		
	}
	
	protected function generateCode($num){
		return base_convert($num, 10, 36);
	}

	public function makeCode($url){
		$url = trim($url);

		if(!filter_var($url, FILTER_VALIDATE_URL)){
			return '';
		}
		Shortener::_construct();		       
		$url = mysqli_escape_string($this->db, $url);
						
		//Check if URL Exist
		$exist = $this->db->query("SELECT code FROM links WHERE url = '{$url}'");

		if($exist->num_rows){
			return $exist->fetch_object()->code;			
		}else{
			//Insert record without a code
			$insert = $this->db->query("INSERT INTO links (url, created) VALUES ('{$url}', NOW())");

			// Generate a code based on inserted ID
			$code = $this->generateCode($this->db->insert_id);

			// Update record with the generated code
			$this->db->query("UPDATE links SET code = '{$code}' WHERE url = '{$url}'");

			return $code;
		}

	}

	public function getUrl($code){
		$this->_construct();

		$code = mysqli_escape_string($this->db, $code);
		$code = $this->db->query("SELECT url FROM links WHERE code = '$code'");

		if ($code->num_rows){
			return $code->fetch_object()->url;
		}

		return '';
	}
}