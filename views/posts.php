<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/post.php" );
require ( get_require_dir() . "/like.php" );
require ( get_require_dir() . "/navbar.php" );

// submitボタンが押された場合の処理
if ( is_Submit() ) {
    if ( isset( $_FILES["image"] ) && is_uploaded_file( $_FILES["image"]["tmp_name"] ) ) {
        $filename = image_upload( $_FILES["image"] );
    } else {
        $filename = null;
    }
    post_insertOrUpdate( 'insert' , get_Post( 'title' ), get_Post( 'content' ), $filename );
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

define( "TEXT", "新規投稿" );

require ( get_partials_dir() . "/post_form.php" );

$query = "SELECT * FROM posts ORDER BY updated_at DESC";
$result = query( $query );
$posts = pagination( $result['datas'], 10 );
?>

<?php if ( count( $posts ) > 0 ): ?>
<?php foreach ( $posts as $post ): ?> 
<?php require ( get_partials_dir() . "/post.php" ); ?>
<?php endforeach; ?>
<?php endif; ?>