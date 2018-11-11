<?php 

require (  "../setting_func.php" );
include ( get_views_dir() . "/navbar.php" );

// submitボタンが押された場合の処理
if ( isset( $_POST['action'] ) ) {
    user_authenticate( $_POST['user_name'], $_POST['nickname'], $_POST['email'] );
}

define( "FORMTITLE", "ログインはこちら" );
define( "BUTTONTEXT", "ログインする" );
define( "URL", "register.php" );
define( "LINKTEXT", "会員登録はこちら" );

require ( get_partials_dir() . "/user_form.php" );