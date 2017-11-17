<?php
	require_once 'core/init.php';
	// ket noi database
	$db = DB::getInstance();
	echo "Lay ta ca cac ban ghi";

	//print_r($db->getAll("tbl_users")->results());
	//var_dump($db->getAll("tbl_users"));
	//
	// kiem tra xem co du lieu k
	$count_user = $db->getAll("tbl_users")->count();
	if($count_user > 0){
		$array_users = $db->getAll("tbl_users")->results();
		print_r($array_users);
		foreach ($array_users as $value) {
			echo $value->id . '<br />';
		}
	}else
		echo "khong co du lieu";
	