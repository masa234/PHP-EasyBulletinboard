<?php 

require (  "../setting_func.php" );
include ( get_functions_dir() . "/dbconfig.php" );
include ( get_functions_dir() . "/session.php" );
include ( get_functions_dir() . "/user.php" );
include ( get_views_dir() . "/navbar.php" );

// submitボタンが押された場合の処理
if ( isset( $_POST['action'] ) ) {
    user_register( $_POST['user_name'], $_POST['nickname'], $_POST['email'], $_POST['password'] );
}

define( "FORMTITLE", "アカウント作成" );
define( "BUTTONTEXT", "アカウントを作成する" );
define( "URL", "authenticate.php" );
define( "LINKTEXT", "ログインはこちら" );

require ( get_partials_dir() . "/user_form.php" );