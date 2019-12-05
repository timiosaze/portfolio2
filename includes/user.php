<?php 

	class User extends Db_object {

		protected static $db_table = "users";
		protected static $db_table_fields = array('username', 'usermail', 'password');
		public $id;
		public $username;
		public $usermail;
		public $password;


		public static function password_encrypt($the_password){

			return password_hash($the_password, PASSWORD_BCRYPT, array('cost'=>12));

		}

		public static function verify_user($username, $password){
			global $database;

			$username = $database->escaped_string($username);
			$password = $database->escaped_string($password);

			$sql = "SELECT * FROM ". self::$db_table . " WHERE username = '{$username}' LIMIT 1 ";

			$the_result_array = self::find_by_query($sql);
			
			return !empty($the_result_array) ? array_shift($the_result_array) : false;

			
		}
	}

 ?>