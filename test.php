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
		//print_r($array_users);
		foreach ($array_users as $value) {
			echo $value->id . '<br />';
		}
	}else
		echo "khong co du lieu";


    // them moi ban ghi
    $args = array(
        'user_fullname' => 'thanh admin',
        'user_name' => 'thanhkuet13',
        'user_password' => '679bd593a4f0e4986624a865838177cfcb74a5289131596861a1d994b3b6',
        'user_email' => 'thanhadmin@gmail11.com',
        'user_salt' => 'ªOÒUÇwÍ¥í~ŒÀzøŠ/|„lË–’ Ù„w-4',
        'user_created' => date('d-m-Y: H:s'),
        'group_id' => 1
    );
    $args1 = array(
        'user_fullname' => 'thanh admin',
        'user_name' => 'thanh',
        'user_password' => '3297039ab7a565bbec795d9f4bcbc46b202942b6797eb97fce28f0b4de030a5c',
        'user_email' => 'thanhadmin@gmail11.com',
        'user_salt' => '��T!�������R���n�N�����',
        'user_created' => date('d-m-Y: H:s'),
        'group_id' => 1
    );
  //  var_dump($db->insert('tbl_users', $args));
//    $user_created = $user->create($args);
    $user->create($args1)
?>