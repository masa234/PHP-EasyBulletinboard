<?php

require (  "../setting_func.php" );
include ( get_require_dir() . "/dbconfig.php" );
include ( get_require_dir() . "/common.php" );
include ( get_require_dir() . "/session.php" );
include ( get_require_dir() . "/post.php" );
include ( get_require_dir() . "/navbar.php" );

// getパラメータでidが入力されていてそれが数値の場合
if ( isset( $_REQUEST['id'] ) && is_numeric( $_REQUEST['id'] )  
     && isCurrentUser( 'posts', $_REQUEST['id'] ) ) {

        $post = get_post( $_REQUEST['id'] );
} else {
    header( "Location:posts.php" );
    exit();
}    

if ( isset( $_POST['action'] ) ) {
    if( isset( $_FILES['image'] ) && is_uploaded_file( $_FILES["image"]["tmp_name"] ) ) {
        // ユーザのイメージ画像にしたい画像が送られてきた場合
        $filename = image_upload( $_FILES["image"] );
    } else {
        // 画像が選択されていない場合（画像は変更しない）
        $filename = $post['image']; 
    }

    // 更新処理
    post_insertOrUpdate( 'update' , $_POST['title'], $_POST['content'], $filename, $post['id'] );
}

define( "TEXT", "投稿編集画面" );
require ( get_partials_dir() . "/post_form.php" );