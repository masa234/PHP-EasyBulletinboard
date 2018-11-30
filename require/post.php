<?php 

function post_insertOrUpdate( $order, $title, $content, $filename, $post_id = null  ) {
    $title = escape( $title );
    $content = escape( $content );

    $now = get_current_datetime();
    $user_id = session_get( 'id' );
    
    $errors = post_validation( $title, $content, $post_id );

    if ( count( $errors ) > 0 ) {
        error_display( $errors );
        return;
    }

    // create
    if ( $order == 'insert' ) {
        $query = "
            INSERT INTO posts
                ( title, content, image, created_at, updated_at, user_id
            ) VALUES (
                '$title', '$content', '$filename', '$now', '$now', '$user_id' )
            ";

        $message = '新規投稿に成功しました';
    } else if ( $order == 'update' ) {

        if ( ! isCurrentUser( 'posts' ,$post_id ) ) {
            header( "Location: posts.php" );
            exit(); 
        }

        $query = "
        UPDATE posts SET 
            title = '$title',
            content = '$content',
            image = '$filename',
            updated_at = '$now'
        WHERE id = '$post_id'
        AND user_id = '$user_id'
        ";

        $message = '投稿の編集に成功しました';
    } 

    query( $query );
    message_display( 'success', $message );
}   

// updateの際は、引数にpostのidを指定する
function post_validation( $title, $content, $post_id = null ) {
    $errors = array();

    // updateの際は、編集する投稿の情報を先に取得する
    if ( $post_id ) {
        $post = get_post( $post_id );
    } else {
        $post['title'] = null;
    }

    if ( ! mb_strlen( $title ) ) {
        $errors[] = "タイトルが空です";
    } else if ( is_numeric( $title ) ) {
        $errors[] = "タイトルは文字列でなくてはいけません";
    } else if ( mb_strlen( $title ) > 30 ) {
        $errors[] = "タイトルは30文字以内で入力してください";
    } else if ( ! isUniq( 'posts', 'title', $title ) // 第一条件は、入力したタイトルが一意の場合,true
                && $title != $post['title'] ) { // 第二条件はinsert時は常にtrue, update時は編集するpostとタイトルを指定した場合true
        $errors[] = "違うタイトルを指定してください";
    }

    if ( ! mb_strlen( $content ) ) {
        $errors[] = "本文が空です";
    } else if ( is_numeric( $content ) ) {
        $errors[] = "タイトルは文字列でなくてはいけません";
    } else if ( mb_strlen( $content ) > 200 ) {
        $errors[] = "本文は200文字以内で入力してください";
    }

    return $errors;
}

function post_delete( $post_id ) {

    $post_id = escape( $post_id );
    
    if ( ! isCurrentUser( 'posts' ,$post_id ) ) {
        header( "Location: posts.php" );
        exit();
    }

    $user_id = session_get( 'id' );

    $query ="
        DELETE FROM posts 
        WHERE id = '$post_id'
        AND user_id = '$user_id'
        ";

    query( $query );

    message_display( 'success', '削除に成功しました' );
}
