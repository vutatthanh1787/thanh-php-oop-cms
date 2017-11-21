<?php 
	echo "index.php";
	require_once 'core/init.php';
	if (Session::exists('success')) {
		echo Session::flash('success');
	}


	$db = DB::getInstance();
	$db->insert('tbl_users', array(
		'user_name' 	=> 'admin,
		'user_password 	=> 'admin1234',
		'group_id' 		=> 1 
	));