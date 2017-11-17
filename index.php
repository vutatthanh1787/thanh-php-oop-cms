<?php 
	//echo "index";
	require_once 'core/init.php';
	//print_r(DB::getInstance()->query("SELECT * FROM tbl_users"));
	$user = DB::getInstance()->update('tbl_users', 1, array(
			'user_name' => 'thanhvip',
			'user_password' => 'thanhvip',
			'user_salt' => 'salt'
	));

	DB::getInstance()->delete('tbl_users', 4);