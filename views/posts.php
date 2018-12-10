<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/user.php" );
require ( get_require_dir() . "/post.php" );
require ( get_require_dir() . "/relationship.php" );
require ( get_require_dir() . "/like.php" );
require ( get_require_dir() . "/retweet.php" );


dump( $_POST );

// submitボタンが押された場合の処理
if ( is_Submit() ) {
    if ( isset( $_FILES["image"] ) && is_uploaded_file( $_FILES["image"]["tmp_name"] ) ) {
        $image_path = image_upload( $_FILES["image"] );
    } else {
        $image_path = null;
    }
    post_updateOrCreate( 'create' , get_Post( 'title' ), get_Post( 'content' ), $image_path );
}


if ( is_Submit( 'post_delete' ) ) {
    post_delete( get_Post( 'post_id' ) );
}

if ( is_Submit( 'like' ) ) {
    like( get_Post( 'post_id' ) );
}

if ( is_Submit( 'unlike' ) ) {
    unlike( get_Post( 'post_id' ) );
}

if ( is_Submit( 'retweet' ) ) {
    retweet( get_Post( 'post_id' ) );
}

if ( is_Submit( 'unretweet' ) ) {
    unRetweet( get_Post( 'post_id' ) );
}

define( "TEXT", "新規投稿" );

require ( get_partials_dir() . "/post_form.php" );

$feed_posts = get_feed();
$feed_posts = pagination( $feed_posts['datas'], 10 );

require_foreach( $feed_posts , 'post',  get_partials_dir() . "/post.php" );