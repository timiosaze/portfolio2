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

		public static function login_user($username, $password){

			$login_results = self::verify_user($username, $password);
			$hashed_password = $login_results->password;
			$id = $login_results->id;
			$username= $login_results->username;
			
			if(password_verify($password, $hashed_password)){
				 $_SESSION['id'] = $id;
				 $_SESSION['username'] = $username;
				 switch ($_SESSION['link']) {
				 	case 'note':
				 		redirect("../project/notes.php");
				 		exit();
				 		break;
				 	case 'contact':
				 		redirect("../project/contacts.php");
				 		exit();
				 		break;
				 	case 'appoint':
				 		redirect("../project/appointments.php");
				 		exit();
				 		break;
				 	default:
				 		redirect("../index.php");
				 		exit();
				 		break;
				 }
			}
		}

		public static function username_exists($username){
			global $database;

			$sql = "SELECT username FROM ". self::$db_table . " WHERE username = '{$username}' ";
			$result_query = $database->query($sql);
			if(mysqli_num_rows($result_query) > 0) {
				return true;
			} else {
				return false;
			}
		}

		public static function usermail_exists($usermail){
			global $database;

			$sql = "SELECT usermail FROM " . self::$db_table . " WHERE usermail = '{$usermail}' ";
			$result_query = $database->query($sql);
			if(mysqli_num_rows($result_query) > 0){
				return true;
			} else {
				return false;
			}
		}
	}

 ?>