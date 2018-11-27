<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/post.php" );
require ( get_require_dir() . "/like.php" );
require ( get_require_dir() . "/navbar.php" );

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

if ( isset( $_POST['like'] ) ) {
    like( $_POST['post_id'] );
}

if ( isset( $_POST['unlike'] ) ) {
    unlike( $_POST['post_id'] );
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