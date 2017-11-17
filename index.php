<?php 
	//echo "index";
	require_once 'core/init.php';
	//print_r(DB::getInstance()->query("SELECT * FROM tbl_users"));
	$user = DB::getInstance()->insert('tbl_users', array(
										'user_name' => 'Dale',
										'user_password' => '123456',
										'user_salf' => 'salf'
	));
	