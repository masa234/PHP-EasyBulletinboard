<?php 

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/navbar.php" );

// submitボタンが押された場合の処理
if ( isset( $_POST['action'] ) ) {
    authenticate( $_POST['user_name'], $_POST['password'] );
}

define( "FORMTITLE", "ログインはこちら" );
define( "BUTTONTEXT", "ログインする" );
define( "URL", "register.php" );
define( "LINKTEXT", "会員登録はこちら" );

require ( get_partials_dir() . "/user_form.php" );