<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/post.php" );

$post = find( 'posts' ,get_Get( 'id' ) );

// getパラメータでidが入力されていてそれが数値の場合
if ( ! is_numeric( get_Get( 'id' ) )  
     || ! isCurrentUser( 'posts', get_Get( 'id' ) ) || ! $post  ) {
    flash( 'render_404','danger' );
    redirect( 'posts.php' );
}    

if ( is_Submit() ) {
    if( isset( $_FILES['image'] ) && is_uploaded_file( $_FILES["image"]["tmp_name"] ) ) {
        // postのイメージ画像にしたい画像が送られてきた場合
        $image_path = image_upload( $_FILES["image"] );
    } else {
        // 画像が選択されていない場合（画像は変更しない）
        $image_path = $post['image']; 
    }

    // 更新処理
    post_updateOrCreate( 'update' , get_Post( 'title' ), get_Post( 'content' ), $image_path, $post['id'] );
}

define( "TEXT", "投稿編集画面" );
require ( get_partials_dir() . "/post_form.php" );