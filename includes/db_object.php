<?php 

	class Db_object {

		/**** THIS FIRST TWO FUNCTIONS ARE JUST TO CHECK
			  IF THE NAMES OF YOUR DATABASE ROWS ARE THE SAME
			  WITH THE PROPERTIES OF THE CLASS
		****/
		private function has_the_key_atribute($the_key_atribute){

			//GET THE PROPERTIES OF PRESENT CLASS
			$obj_properties = get_class_vars(get_class($this));

			//CHECK IF THE KEYS OF THE CLASS EXIST IN THE PROPERTIES OF THE CLASS
			//WILL RETURN TRUE IF IT IS IN THE PROPERTIES OR ELSE FALSE
			return array_key_exists($the_key_atribute, $obj_properties);

		}

		public static function instantiation($the_result_row){
			//GET THE CLASS AND INSTANTIATE THE CLASS
			$the_class = get_called_class();
			$class_object = new $the_class;

			//CHECK WHETHER THE PROPERTIES OF THE ATTRIBUTE EXIST IN THE DATABASE ROWS
			foreach ($the_result_row as $the_key_atribute => $value) {

				if($class_object->has_the_key_atribute($the_key_atribute)){
					//SAVING THE THE VALUES OF THE RESULT ROW AS THE KEYS 
					$class_object->$the_key_atribute = $value;
				}
				# code...
			}

			return $class_object;
		}

		public static function find_by_query($sql){
			global $database;
			$query_result = $database->query($sql);
			$object_array = [];

			while($row = mysqli_fetch_assoc($query_result)){
				$object_array[] = static::instantiation($row);
			}

			return $object_array;

		}

		public static function find_all(){
			return static::find_by_query("SELECT * FROM " . static::$db_table . " ");
		}

		public static function find_by_id($id){
			$the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id = $id LIMIT 1 ");

			return !empty($the_result_array) ? array_shift($the_result_array) : false; 
		}

		public static function find_user_id($id){
			$the_result_array = static::find_by_query("SELECT user_id FROM " . static::$db_table . " WHERE id = $id");
			return !empty($the_result_array) ? array_shift($the_result_array) : false; 

		}

		protected function properties(){

			$properties = [];

			//PLACE THE VALUES OF THE FORM IN AN ARRAY

			foreach(static::$db_table_fields as $db_field){

				if(property_exists($this, $db_field)){
				
					$properties[$db_field] = $this->$db_field;
				
				}
			}

			return $properties;
		}

		protected function clean_properties(){

			global $database;

			$clean_properties = [];

			foreach($this->properties() as $key => $value){

				$clean_properties[$key] = $database->escaped_string($value);
			}

			return $clean_properties;
		}

		public function create(){
			global $database;

			$properties = $this->clean_properties();

			$sql = "INSERT INTO " . static::$db_table . " ( " . implode(",", array_keys($properties)) . " )";
			$sql .= " VALUES ('" . implode("','", array_values($properties)) . "')";

			if($database->query($sql)){
				$this->id = $database->the_insert_id();
				return true;
			} else {
				return false;
			}


		}

		public function save(){
			return $this->create();
		}

		public function update($id){
			global $database;

			$properties = $this->clean_properties();

			$properties_pair = [];

			foreach ($properties as $key => $value) {
			 	$properties_pair[] = "{$key} = '{$value}'";
			 } 

			 $sql = "UPDATE " . static::$db_table . " SET ";
			 $sql .= implode(", ", $properties_pair);
			 $sql .= " WHERE id = $id";

			 $database->query($sql);

			 return (mysqli_affected_rows($database->connection) == 1) ? true : false;
		}

		public function delete($id){
			global $database;

			$sql = "DELETE FROM " . static::$db_table;
			$sql .= " WHERE id = $id ";
			$sql .= " LIMIT 1";

			$database->query($sql);

			return (mysqli_affected_rows($database->connection) == 1) ? true : false;
		}

		public function count_all(){
			global $database;

			$sql = "SELECT COUNT(*) FROM " . static::$db_table;
			$result_query = $database->query($sql);
			$row = mysqli_fetch_array($result_query);

			return array_shift($row);
		}
	}

 ?>