<?php

require (  "../setting_func.php" );
include ( get_functions_dir() . "/dbconfig.php" );
include ( get_functions_dir() . "/common.php" );
include ( get_functions_dir() . "/session.php" );
include ( get_functions_dir() . "/post.php" );
include ( get_views_dir() . "/navbar.php" );

// submitボタンが押された場合の処理
if ( isset( $_POST['action'] ) ) {
    post_register( $_POST['title'], $_POST['content'] );
}

if ( isset( $_POST['post_delete'] ) ) {
    post_delete( $_POST['post_id'] );
}

define( "TEXT", "新規投稿" );

require ( get_partials_dir() . "/post_form.php" );

$posts = post_all();

foreach ( $posts as $post ) {
    require ( get_partials_dir() . "/post.php" );
}