<?php 

	class Meeting extends Db_object {

		protected static $db_table = "meetings";
		protected static $db_table_fields = array('user_id', 'meeting', 'meeting_date');
		public $id;
		public $user_id;
		public $meeting;
		public $meeting_date;


	}

 ?>