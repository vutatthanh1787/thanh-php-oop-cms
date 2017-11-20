<?php 
	require_once 'core/init.php';
	if(Input::exists()){
		echo Input::get('username');
	}
 ?>
<form action="" method="post">
	<div class="field">
		<label for="username">Username</label>
		<input type="text" name="username" id="username" value="" autocomplete="off">
	</div>
	<div class="field">
		<label for="password">Choose a password</label>
		<input type="password" name="password" id="password">
	</div>

	<div class="field">
		<label for="password_again">Enter your password again</label>
		<input type="password" name="password_again" id="password_again">
	</div>

	<input type="submit" name="Register">

</form>