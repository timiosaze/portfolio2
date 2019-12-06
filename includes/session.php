<?php 

	class Session {

			public $login_status = false;
			public $id;
			public $message;
			public $username;
			public $type;
			public $link;

			function __construct() {
				session_start();

				if(isset($_SESSION['id'])){
					$this->id = $_SESSION['id'];
					$this->login_status = true;
				}

				$this->username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
				$this->message = isset($_SESSION['message']) ? $_SESSION['message'] : null;
				$this->type = isset($_SESSION['type']) ? $_SESSION['type'] : null;
				$this->link = isset($_SESSION['link']) ? $_SESSION['link'] : null;
			}
	 		
	 		public function is_logged_in(){
	 			return $this->login_status;
	 		}

	 		public function set_user_session($id, $username){
	 			$this->id = $_SESSION['id'];
	 			$this->username = $_SESSION['username'];
	 		}

	 		public function set_message($type, $message){
	 			$this->type = $_SESSION['type'] = $type;
	 			$this->message = $_SESSION['message'] = $message;
	 		}

	 		public function set_link($link){
	 			$this->link = $_SESSION['link'];
	 		}
	 		public function logout(){
	 			unset($_SESSION['username']);
	 			unset($_SESSION['id']);
	 			unset($this->link);
	 			unset($_SESSION['link']);
	 			unset($this->id);
	 			unset($this->username);
	 			$this->login_status = false;
	 		}


	}

	$session = new Session();