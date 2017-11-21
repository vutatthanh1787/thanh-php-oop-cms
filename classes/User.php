<?php 
	/**
	* * classes/ User.php
	*/
	class User
	{
		private $_db;
		
		function __construct($user = null)
		{
			$this->_db = DB::getInstance();
		}

		public static function create($fields = array()){
			if (!$this->_db->insert('tbl_users', $fields)){
				throw new Exception('There was a problem creating the account.');
			}
		}
	}
 ?>