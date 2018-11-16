<?php 

require (  "../setting_func.php" );
include ( get_require_dir() . "/dbconfig.php" );
include ( get_require_dir() . "/common.php" );
include ( get_require_dir() . "/session.php" );
include ( get_require_dir() . "/user.php" );
include ( get_require_dir() . "/navbar.php" );

// submitボタンが押された場合の処理
if ( isset( $_POST['action'] ) ) {
    if ( isset( $_FILES['image'] ) && is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {

        if ( $filename = image_upload( $_FILES['image'] ) ) {
            user_insertOrUpdate( 'insert', $_POST['user_name'], $_POST['nickname'], $_POST['email'], $_POST['password'], $filename );
        }
    } else {
        message_display( 'danger',  'ファイルの選択をお願い致します。' );
    }
}

define( "FORMTITLE", "アカウント作成" );
define( "BUTTONTEXT", "アカウントを作成する" );
define( "URL", "authenticate.php" );
define( "LINKTEXT", "ログインはこちら" );

require ( get_partials_dir() . "/user_form.php" );