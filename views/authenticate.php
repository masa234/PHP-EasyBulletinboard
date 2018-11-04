<?php 
// ログイン画面

require (  "../setting_func.php" );
require ( get_functions_dir() . "/dbconfig.php" );
require ( get_functions_dir() . "/session.php" );
require ( get_functions_dir() . "/user.php" );

require_signout();
include ( get_views_dir() . "/navbar.php" );

// 登録ボタンを押したとき 、登録処理
if ( isset( $_POST['action'] ) ) {
	authenticate( $_POST['user_name'], $_POST['email'], $_POST['password']  );
} 

define( "FORMTITLE", "ログイン" ); 
define( "BUTTONTEXT", "ログインする" );
define( "URL", "register.php" );
define( "LINKTEXT", "会員登録はこちら" );

include( get_partials_dir() . "/user_form.php" );
