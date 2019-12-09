<?php 

	class Note extends Db_object {

		protected static $db_table = "notes";
		protected static $db_table_fields = array("user_id", "note");
		public $id;
		public $user_id;
		public $note;
		public $created_at;
		public $updated_at;
		
	}
