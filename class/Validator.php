<?php

class Validator {

		private $data;
		private $errors = [];

		public function __construct($data){
			$this->data = $data;

		}

		private function getField($field){
			if (!isset($this->data[$field])){

				return null;
			}
			return $this->data[$field];

		}


		public function isAlpha($field,$errorMessage){
			if (!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))) {
	  	  	$this->errors[$field] = $errorMessage;

		}
	}

		public function isUniq($field, $db ,$table, $errorMessage){
			$record = $db->query("SELECT ID FROM $table WHERE $field = ?", [$this->getField($field)])->fetch();
	  	
	  		if($record){
	  			$this->errors[$field] = $errorMessage;
	  		}

		}

		public function isEmail($field, $errorMessage){
		  if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
	  	  $this->errors[$field] = $errorMessage;
		}
	}

	public function isConfirmed($field, $errorMessage){
		$value = $this->getField($field);
		$value2 = $this->getField('user_pass_confirm');
		if (empty($value) || $value != $value2) {
          $this->errors[$field] = $errorMessage;
		}
	}


	public function isValid(){
		return empty($this->errors);

	}

	public function getErrors(){
		return $this->errors;
	}

	public function envoi_mail($field,$errorMessage){
			if (preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))) {
	  	  	$this->errors[$field] = $errorMessage;
	  	  }
	}





















}