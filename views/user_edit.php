<?php 

require (  "../setting_func.php" );
require ( get_require_dir() . "/user.php" );

// submitボタンが押された場合の処理
if ( is_Submit() ) {
    if ( password_verify( get_Post( 'current_password' ), session_get( 'password' ) ) ) {
        if ( isset( $_FILES['image'] ) && is_uploaded_file( $_FILES['image']['tmp_name'] ) ) {
            $image_path = image_upload( $_FILES['image'] );
        } else {
            $image_path = session_get( 'image' );
        }
        user_insertOrUpdate( 'update', get_Post( 'user_name' ), get_Post( 'nickname' ), get_Post( 'email' ), get_Post( 'password' ), $image_path );
    } else {
        message_display( 'danger', 'パスワードが違います' );
    } 
} 

define( "FORMTITLE", "ユーザ情報を編集する" );
define( "BUTTONTEXT", "ユーザ情報を更新する" );
define( "URL", "users.php" );
define( "LINKTEXT", "ユーザ一覧はこちら" );

require ( get_partials_dir() . "/user_form.php" );