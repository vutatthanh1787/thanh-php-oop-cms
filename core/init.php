<?php
    @ob_start();
	session_start();
    
    ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	// Tao bien toan cuc
	
	$GLOBALS['config'] = array(
						'mysql' => array(
							'host' 		=> 'localhost',
							'username' 	=> 'root',
							'password' 	=> 'root',
							'db' 		=> 'db_mysql'
						),
						'remember' => array(
							'cookie_name' 	=> 'hash',
							'cookie_expiry' => 604800
						),
						'session' => array(
							'session_name' 	=> 'user',
							'token_name' 	=> 'token'
						)
	);

	spl_autoload_register(function($class){
		require_once 'classes/' . $class . '.php';
	});
    // register user
    /** @var TYPE_NAME $user */
    $user = new User();
	require_once 'functions/sanitize.php';
?>