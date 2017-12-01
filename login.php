<?php
/**
 * Created by PhpStorm.
 * User: thanh
 * Date: 30/11/2017
 * Time: 9:48 SA
 */
?>
<?php
    require_once 'core/init.php';
    if (Input::exists()){
        if (Token::check(Input::get('token'))) {
            // validation input
            $validation = new Validate();
            $validation->check($_POST, array(
                'username' => array(
                    'required' => true
                ),
                'password' => array(
                    'required' => true
                )
            ));

            if ($validation->passed()){
                // validation passed
                // begin login proccess
//                echo Input::get('username');
//                echo '< br />';
//                echo Input::get('password');
//                die();
                $user_logged = $user->login(Input::get('username'), Input::get('password'));
                if ($user_logged)
                    echo 'OK';
                else
                    echo 'Login false';
            }else{
                foreach ($validation->errors() as $error) {
                    echo $error . '<br />';
                }
            }
        }
    }
?>
<form action="" method="post">
    <div class="field">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo escape(Input::get('username')); ?>">
    </div>
    <div class="field">
        <label for="username">Password:</label>
        <input type="password" name="password" value="">
    </div>
    <div class="field">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
        <input type="submit" name="btn_submit" value="Log In">
    </div>
</form>
