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

        /**
         * DB constructor.
         */
        function __construct()
		{
			try{
				$this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') .';dbname=' . Config::get('mysql/db'),
                                                            Config::get('mysql/username'),
                                                            Config::get('mysql/password'),
                                            					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'") );
			} catch(PDOException $msg){
				die($msg->getMessage());
			}
		}
        /**
         * @return DB|null
         */
        public static function getInstance()
		{
			if (!isset(self::$_instance)){
				self::$_instance = new DB();
			}
			return self::$_instance;
		}
        /**
         * @param $sql
         * @param array $params
         * @return $this
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
                }else{
                    $this->_error = true;
                }
            }
            return $this;
        }

        /**
         * @param $action
         * @param $table
         * @param array $where
         * @return $this|bool
         */
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

        /**
         * @param $table
         * @return $this
         */
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

        /**
         * @param $table
         * @param $where
         * @return bool|DB
         */
        public function get($table, $where){
            return $this->action('SELECT *', $table, $where);
        }

        /**
         * @param $table
         * @param $where
         * @return bool|DB
         */
        public function delete($table, $where){
            return $this->action('DELETE', $table, $where);
        }

        /**
         * @param $table
         * @param array $fields
         * @return bool
         */
        public function insert($table, $fields = array()){
            $keys = array_keys($fields);
            $values = '';
            $x = 1;
            foreach($fields as $field){
                $values .= '?';
                if($x < count($fields)){
                    $values .= ', ';
                }
                $x++;
            }
            $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})" ;
            if(!$this->query($sql, $fields)->error()){
                return true;
            }
            return false;
        }

        /**
         * @param $table
         * @param $id
         * @param $fields
         * @return bool
         */
        public function update($table, $id, $fields){
            $set = '';
            $x = 1;
            foreach($fields as $name => $value){
                $set .= "{$name} = ?";
                if($x < count($fields)){
                    $set .= ', ';
                }
                $x++;
            }
            $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
            if(!$this->query($sql, $fields)->error()){
                return true;
            }
            return false;
        }

		/*
		** Ham tra ve so luong ban ghi
		 */
        /**
         * @return int
         */
        public function count(){
			return $this->_count;
		}

        /**
         * @return mixed
         */
        public function results(){
			return $this->_results;
		}

        /**
         * @return mixed
         */
        public function first(){
			return $this->results()[0];
		}

        /**
         * @return bool
         */
        public function error(){
			return $this->_error;
		}

	}
	
?>