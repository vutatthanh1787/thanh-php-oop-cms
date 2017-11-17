<?php 	
	// DB.php
	/**
	* * class DB
	*/
	class DB
	{
		// Khoi tao bien
		private static $_instance = null;
		private $_pdo,
				$_query,
				$_error = false,
				$_results,
				$_count = 0;
		
		function __construct()
		{
			try{
				$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') .';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'),
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'") );
			} catch(PDOException $msg){
				die($msg->getMessage());
			}
		}
		/*
		** Ham getInstance
		** New khong ton tai bien $_instance
		** $_instance khoi tao DB
		** Tra ve $_instance
		 */
		public static function getInstance()
		{
			if (!isset(self::$_instance)){
				self::$_instance = new DB();
			}
			return self::$_instance;
		}
		/*
		** Ham query
		 */
		
		public function query($sql, $params = array()){
			$this->_error = false;
			if($this->_query = $this->_pdo->prepare($sql)){
				$x = 1;
				if(count($params)){
					foreach($params as $param){
						$this->_query->bindValue($x, $param);
						$x++;
					}
				}
				if($this->_query->execute()){
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();
					//print_r('count = ' . $this->_query->rowCount());
				}else{
					$this->_error = true;
				}
			}
			return $this;
		}

		public function action($action, $table, $where = array()){
			if(count($where) === 3){
				$operators = array('=', '>', '<', '>=', '<=');
				$field = $where[0];
				$operator = $where[1];
				$value = $where[2];
				if(in_array($operator, $operators)){
					$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
					if(!$this->query($sql, array($value))->error()){
						return $this;
					}
				}
			}
			return false;
		}

		public function getAll($table){
			$this->_error = false;
			$sql = "SELECT * FROM {$table}";
			if ( $this->_query = $this->_pdo->prepare($sql) ){
				if ($this->_query->execute()){
					$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
					$this->_count = $this->_query->rowCount();
				}
				else
					$this->_error = true;
			}
			
			return $this;
		}

		public function get($table, $where){
			return $this->action('SELECT *', $table, $where);
		}

		public function insert($table, $fields = array()){
			// Lay ra tat ca cac key
			$keys = array_keys($fields);
			//print_r($keys);
			$values = '';
			$i = 1;
			foreach ($fields as $field) {
				$values .= '?';
				if($i < count($fields)){
					$values .= ', ';
				}
				$i++;
			}
			//echo $values;
			$sql = "INSERT INTO {$table}(`" . implode('`, `', $keys) . "`) VALUES({$values})";
			//echo $sql;
			if (!$this->query($sql, $fields)->error()){
				return true;
			}
			return false;
		}

		public function update($table, $id, $fields = array()){

			$set = '';
			$i = 1;
			foreach ($fields as $name => $value) {
				$set .= "{$name} = ?";
				if ( $i < count($fields) ) {
					$set .= ', ';
				}
				$i++;
			}
			//echo $set;
			$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}"; 
			//echo $sql;
			if (!$this->query($sql, $fields)->error()) {
				return true;
			}
			return false;
		}

		public function delete(	$table, $id){
			$sql = "DELETE FROM {$table} WHERE id = {$id}";
			if(!$this->query($sql)->error())
				return true;
			return false;
		}

		/*
		** Ham tra ve so luong ban ghi
		 */
		public function count(){
			return $this->_count;
		}


		public function results(){
			return $this->_results;
		}

		public function first(){
			return $this->results()[0];
		}

		public function error(){
			return $this->_error;
		}

	}
	
?>