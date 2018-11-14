<?php

require (  "../setting_func.php" );
include ( get_functions_dir() . "/dbconfig.php" );
include ( get_functions_dir() . "/common.php" );
include ( get_functions_dir() . "/session.php" );
include ( get_functions_dir() . "/post.php" );
include ( get_views_dir() . "/navbar.php" );

if ( isset( $_POST['action'] ) ) {
    post_insertOrUpdate( 'update', $_POST['title'], $_POST['content'], $_POST['post_id'] );
}

// getパラメータでidが入力されていてそれが数値の場合
if ( isset( $_REQUEST['id'] ) && is_numeric( $_REQUEST['id'] ) )  {
    $post = post_edit( $_REQUEST['id'] );
    define( "TEXT", "投稿編集画面" );
    require ( get_partials_dir() . "/post_form.php" );
} else {
    header( "Location: posts.php" );
    exit();    
}

