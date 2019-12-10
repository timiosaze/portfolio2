<?php 

	class Contact extends Db_object {

		protected static $db_table = "contacts";
		protected static $db_table_fields = array('user_id', 'contact_name', 'contact_number');
		public $id;
		public $user_id;
		public $contact_name;
		public $contact_number;


	}

