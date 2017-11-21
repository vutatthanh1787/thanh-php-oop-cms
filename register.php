<?php 
	//die('register.php');
	require_once 'core/init.php';
	if(Input::exists()){
		if (Token::check(Input::get('token'))) {

			$validate = new Validate();
			$validation = $validate->check($_POST, array(
				'user_name' => array(
					'required' 	=> true,
					'min' 		=> 2, 
					'max' 		=> 20,
					'unique' 	=> 'tbl_users'
				),
				'password' => array(
					'required' 	=> true,
					'min' 		=> 6
				),
				'password_again' => array(
					'required' 	=> true,
					'matches' 	=> 'password'
				),
				'user_fullname' => array(
					'required' 	=> true,
					'min' 		=> 2,
					'max' 		=> 50
				)
			));

			if ($validation->passed()){
				// passed
				$user = new User();
				$salt = Hash::salt(32);
				//die('111');
				try {
					$user->create(array(
						'user_fullname' => Input::get('user_fullname'),
						'user_name' => Input::get('user_name'),
						'user_password' => Hash::make(Input::get('password'), $salt),
						'user_email' => 'account@gmail.com',
						'user_salt' => $salt,
						'user_created' => date('d-m-Y H:i:s'),
						'group_id' => 1
					));
				} catch (Exception $e) {
					die($e->getMessage());
				}

				// Session::flash('success', 'Bạn đã đăng ký thành công.');
				// header("Location: index.php");
			} else{
				// output errors
				foreach ($validation->errors() as $error) {
					echo $error . '<br />';
				}
			}
		}
	}
 ?>
 <?php 
 
  ?>
<form action="" method="post">

	<div class="field">
		<label for="name">Họ và tên</label>
		<input type="text" name="user_fullname" id="user_fullname" value="<?php echo escape(Input::get('user_fullname')) ?>">
	</div>

	<div class="field">
		<label for="username">Tên đăng nhập</label>
		<input type="text" name="user_name" id="user_name" value="<?php echo escape(Input::get('user_name')) ?>" autocomplete="off">
	</div>
	<div class="field">
		<label for="password">Mật khẩu</label>
		<input type="password" name="password" id="password">
	</div>

	<div class="field">
		<label for="password_again">Nhập lại mật khẩu</label>
		<input type="password" name="password_again" id="password_again">
	</div>	

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" name="Đăng ký">

</form> 