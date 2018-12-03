<?php 

require (  "../setting_func.php" );
require ( get_require_dir() . "/user.php" );

// submitボタンが押された場合の処理
if ( is_Submit() ) {
    if ( isset( $_FILES['image'] ) && is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
        $image_path = image_upload( $_FILES['image'] );
    } else {
        $image_path = null;
    }
    user_insertOrUpdate( 'insert', get_Post( 'user_name' ), get_Post( 'nickname' ), get_Post( 'email' ), get_Post( 'password' ), $image_path );
}

define( "FORMTITLE", "アカウント作成" );
define( "BUTTONTEXT", "アカウントを作成する" );
define( "URL", "authenticate.php" );
define( "LINKTEXT", "ログインはこちら" );

require ( get_partials_dir() . "/user_form.php" );