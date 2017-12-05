<?php
    require_once 'core/init.php';
    if (!$user->isLoggedIn()){
        Redirect::to('index.php');
    }

    if (Token::check(Input::get('token'))){
        $validation = new Validate();
        $validation->check($_POST, array(
            'password_current' => array(
                'required' => true,
                'min' => 4
            ),
            'password_new' => array(
                'required' => true,
                'min' => 4
            ),
            'password_new_again' => array(
                'required' => true,
                'min' => 4,
                'matches' => 'password_new'
            )
        ));
        if ($validation->passed()){
            // Change password
            // Kiem tra password hien tai
            if (md5(Input::get('password_current')) === $user->data()->user_password){
                $args = array(
                    'user_password' => md5(Input::get('password_new'))
                );
                $user->update($args);
                Session::put('home', 'Bạn cập nhật mật khẩu thành công.');
                Redirect::to('index.php');
            }else{
                echo 'Bạn nhập mật khẩu hiện tại không đúng!';
            }
        }else{
            // Display errors
            foreach ($validation->errors() as $error){
                echo $error, '<br />';
            }
        }
    }

?>
<form action="" method="post">
    <div class="field">
        <label for="password_current">Mật khẩu hiện tại:</label>
        <input type="text" value="" name="password_current">
    </div>
    <div class="field">
        <label for="password_new">Mật khẩu mới:</label>
        <input type="text" value="" name="password_new">
    </div>
    <div class="field">
        <label for="password_new_again">Nhập lại mật khẩu mới:</label>
        <input type="text" value="" name="password_new_again">
    </div>
    <div class="field">
        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
        <input type="submit" value="Thay đổi">
    </div>
</form>
