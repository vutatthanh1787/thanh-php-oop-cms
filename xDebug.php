<?php 
	/**
	* 
	*/
	Class Foo() 
	{

	    public function bar(Array $arr)
	    {
	        $arr = self::fooBar($arr); // Breakpoint
	        return $arr;
	    }

	    public function fooBar(Array $arr)
	    {
	        return array_values($arr);
	    }
	}
 ?>