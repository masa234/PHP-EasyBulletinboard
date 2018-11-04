<?php 
// アカウント登録画面

require (  "../setting_func.php" );
require ( get_functions_dir() . "/dbconfig.php" );
require ( get_functions_dir() . "/session.php" );
require ( get_functions_dir() . "/user.php" );

require_signout();
include ( get_views_dir() . "/navbar.php" );

// 登録ボタンを押したとき 、登録処理
if ( isset( $_POST['action'] ) ) {
	register( $_POST['user_name'], $_POST['email'], $_POST['password']  );
} 

define( "FORMTITLE", "アカウント作成" ); 
define( "BUTTONTEXT", "アカウントを作成する" );
define( "URL", "authenticate.php" );
define( "LINKTEXT", "ログインはこちら" );

include( get_partials_dir() . "/user_form.php" );