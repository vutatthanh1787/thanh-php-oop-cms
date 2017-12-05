<?php
    require_once 'core/init.php';
    if (!$user->isLoggedIn()){
        Redirect::to('index.php');
    }
    if (Input::exists()){
        if (Token::check(Input::get('token'))){
            $validation = new Validate();
            $validation->check($_POST, array(
                'name' => array(
                    'required' => true,
                    'min' => 4
                )
            ));
            if ($validation->passed()){
                // Thuc hien update user
                try{
                    $user->update(array(
                        'user_fullname' => Input::get('name')
                    ));
                    Session::put('home', 'Bạn đã cập nhật thông tin thành công.');
                    Redirect::to('index.php');
                } catch (Exception $e ){
                    die($e->getMessage());
                }
            }else{
                foreach ($validation->errors() as $error){
                    echo $error . '<br />';
                }
            }
        }
    }
?>
<form action="" method="post">
    <div class="field">
        <label for="name">Họ và tên:</label>
        <input type="text" name="name" value="<?php echo escape($user->data()->user_fullname); ?>">
    </div>
    <div class="field">
        <input type="submit" value="Cập nhật">
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    </div>

</form>
