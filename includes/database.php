<?php 

require_once("config.php");

class Database {

	public $connection;

	public function __construct(){
		$this->open_db_connection();
	}
	
	public function open_db_connection() {

		$this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

		if($this->connection->errno){
			die("Database failed error" . $this->connection->error);
		} 

	}

	private function confirmQuery($result_query){

		if(!$result_query){
			die("Query Failed" . $this->connection->error);
		}

	}

	public function query($sql){
		$result = $this->connection->query($sql);

		$this->confirmQuery($result);

		return $result;
	}

	public function escaped_string($string){
		$escaped_string = $this->connection->real_escape_string($string);

		return $escaped_string;
	}

	public function the_insert_id(){

		return mysqli_insert_id($this->connection);
	
	}

}

$database = new Database();

