<?php 
	class validations
	{
		public $errorData = [];
		private $postdata;
		private static $fields = ['email','password'];
		public function __construct($post){
			$this->postdata = $post;
		}
		public function formValidation(){
			foreach (self::$fields as $field){
				if(!array_key_exists($field, $this->postdata)){
					trigger_error("$field is not present in data");
					return;
				}
			}
			$this->validEmail();
			$this->validPassword();
			return $this->errorData;
		}
		public function validEmail()
		{
			$email = trim($this->postdata['email']);
			if(empty($email)){
				$this->addError('email', 'The email field is required !');
			}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			  $this->addError('email', 'Please enter a valid email address');
			}
		}
		public function validPassword()
		{
			$password = trim($this->postdata['password']);
			if (empty($password)) {
				$this->addError('password', 'The password field is required !');
			  }
		}
		public function addError($key,$val){
			$this->errorData[$key] = $val;
		}
	
	}

?> 