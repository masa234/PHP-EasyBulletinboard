<?php

require (  "../setting_func.php" );
include ( get_require_dir() . "/dbconfig.php" );
include ( get_require_dir() . "/common.php" );
include ( get_require_dir() . "/session.php" );
include ( get_require_dir() . "/post.php" );
include ( get_require_dir() . "/navbar.php" );

// submitボタンが押された場合の処理
if ( isset( $_POST['action'] ) ) {
    if ( isset( $_FILES["image"] ) && is_uploaded_file( $_FILES["image"]["tmp_name"] ) ) {
        
        if ( $filename = image_upload( $_FILES["image"] ) ) {
            post_insertOrUpdate( 'insert' , $_POST['title'], $_POST['content'], $filename );
        }
    }  else {
        message_display( 'danger',  'ファイルの選択をお願い致します。' );
    }
}

if ( isset( $_POST['post_delete'] ) ) {
    post_delete( $_POST['post_id'] );
}

define( "TEXT", "新規投稿" );

require ( get_partials_dir() . "/post_form.php" );

$posts = get_all( 'posts', 'updated_at', 'DESC' );

foreach ( $posts as $post ) {
    require ( get_partials_dir() . "/post.php" );
}