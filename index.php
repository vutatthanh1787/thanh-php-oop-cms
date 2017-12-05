<?php
    require_once 'core/init.php';
    if (Session::exists('home')) {
        echo Session::flash('home');
    }
    // Ton tai 1 user login
    if ($user->isLoggedIn()){
?>

    <p>Hello <?php echo escape($user->data()->user_fullname); ?>!</p>
        <?php if ($user->hasPermission('admin')){ ?>
            <ul>
                <li><a href="logout.php">Thoát</a></li>
                <li><a href="update.php">Cập nhật thông tin</a></li>
                <li><a href="changepassword.php">Thay đổi mật khẩu</a></li>
            </ul>
        <?php } elseif ($user->hasPermission('editor')){ ?>
            <h1>Editor</h1>
        <?php } else{ ?>
            <h1>Member</h1>
        <?php } ?>
<?php
    }else{
        echo '<p>Bạn cần <a href="register.php">đăng ký</a> hoặc <a href="login.php">đăng nhập</a> vào hệ thống</p>';
    }
?>