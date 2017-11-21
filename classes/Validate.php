<?php 
	// classes/Validation
	/**
	* * Validate
	*/
	class Validate
	{
		// Khai bao
		private $_passed = false,
				$_errors = array(),
				$_db = null;
		
		function __construct()
		{
			// ket noi db
			$this->_db = DB::getInstance();
		}

		public function check($source, $items = array()){
			foreach ($items as $item => $rules) {
				//print_r($rules);
				foreach ($rules as $rule => $rule_value) {
					//echo "{$item} {$rule} must be {$rule_value}<br />";
					$value = trim($source[$item]);
					if ($rule === 'required' && empty($value)) {
						$this->addError("{$item} không được để trống!");
					}else if (!empty($value)){
						switch ($rule) {
							case 'min':
								if (strlen($value) < $rule_value) {
									$this->addError("{$item} nhập ít nhất {$rule_value} kí tự!");
								}
								break;
							case 'max':
								if (strlen($value) > $rule_value) {
									$this->addError("{$item} nhập không quá {$rule_value} kí tự!");
								}
								break;
							case 'matches':
								if ($value != $source[$rule_value]) {
									$this->addError("{$item} nhập không đúng!");
								}
								break;
							case 'unique':
								$ck = $this->_db->get($rule_value, array($item, '=', $value));
								if ($ck->count() > 0) {
									$this->addError("{$item} đã tồn tại");
								}
								break;
						}
					}
				}
			}

			if (empty($this->_errors)) {
				$this->_passed = true;
			}
			return $this;
		}

		private function addError($errors){
			$this->_errors[] = $errors;
		}

		public function errors(){
			return $this->_errors;
		}

		public function passed(){
			return $this->_passed;
		}
	}
 ?>