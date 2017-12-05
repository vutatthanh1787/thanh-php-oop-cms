<?php
require_once 'core/init.php'; //echo 'index.php ';
if (Input::exists()){
    // echo "I have been run1";
    if(Token::check(Input::get('token'))){

        //echo "I have been run2";
        $validate = new Validate();
        $validation = $validate->check($_POST,array(
            'user_name' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'tbl_users'
            ),
            "user_password" => array(
                'required' => true,
                'min' => 4
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'user_password'
            ),
            'user_fullname' => array(
                'required' => true,
                'min' => '2',
                'max' => '50'
            ),
            'user_email' => array(
                'required' => true,
                'unique' => 'tbl_users'
            )
        ));

        if($validation->passed()){
            try{
                $args = array(
                    'user_fullname' => Input::get('user_fullname'),
                    'user_name' => Input::get('user_name'),
                    'user_password' => md5(Input::get('user_password')),
                    'user_email' => Input::get('user_email'),
                    'user_created' => date('d-m-Y: H:s'),
                    'group_id' => 1
                );
                $user->create($args);
            } catch(Exception $e){
                die($e->getMessage());
            }
            //echo "Passed";
            Session::flash('home','You were registered successfully and can now log in!');
            //Redirect::to(404);
            Redirect::to('index.php');
        } else {
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
            // print_r($validation->errors());
            // output error
        }
    }

}

/*

if (Input::exists()){
	echo Input::get('username');
}

if (Input::exists()){
	echo "Submitted";
}

*/

?>


<form action="" method="post">
    <div class= "field">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" name="user_name" id="user_name" value="<?php echo escape(Input::get('user_name')); ?>" autocomplete="off">
    </div
    <div class= "field">
        <label for="password">Mật khẩu:</label>
        <input type="password" name="user_password" id="password" autocomplete="off">
    </div>
    <div class= "field">
        <label for="password again">Nhập lại mật khẩu:</label>
        <input type="password" name="password_again" id="password_again" autocomplete="off">
    </div>
    <div class= "field">
        <label for="name">Họ và tên:</label>
        <input type="text" name="user_fullname" id="name" value="<?php echo escape(Input::get('user_fullname')); ?>" autocomplete="off">
    </div>
    <div class="field">
        <label for="email">Hòm thư điện tử:</label>
        <input type="email" name="user_email" value="<?php echo escape(Input::get('user_email'))?>" />
    </div>
    
    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <input type="submit" value="Register">
</form>