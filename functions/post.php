<?php 

function post_register( $title, $content ) {
    
    $errors = post_validation( $title, $content );

    if ( count( $errors) == 0 ) {
        post_insertORUpdate( 'insert' , $title, $content );
    }

    error_display( $errors );
}

function post_validation( $title, $content ) {

    $errors = array();

    if ( ! mb_strlen( trim( $title ) ) ) {
        $errors[] = "タイトルが空です";
    } else if ( mb_strlen( trim( $title ) ) > 30 ) {
        $errors[] = "タイトルは30文字以内で入力してください";
    } else if ( ! isUniq( 'posts', 'title', trim( $title ) ) ) {
        $errors[] = "違うタイトルを指定してください";
    } else if ( is_numeric( trim( $title ) ) ) {
        $errors[] = "タイトルは文字列でなくてはいけません";
    }

    if ( ! mb_strlen( trim( $content ) ) ) {
        $errors[] = "本文が空です";
    } else if ( mb_strlen( trim( $content ) ) > 200 ) {
        $errors[] = "本文は200文字以内で入力してください";
    } else if ( is_numeric( trim( $content ) ) ) {
        $errors[] = "本文は文字列でなくてはいけません";
    }

    return $errors;
}

function post_insertORUpdate( $order, $title, $content ) {

    $title = escape( $title );
    $content = escape( $content );

    $now = get_current_datetime();
    $user_id = session_get( 'user_id' );

    // create
    if ( $order == 'insert' ) {
        $query = "
            INSERT INTO posts
                ( title, content, created_at, updated_at, user_id
            ) VALUES (
                '$title', '$content', '$now', '$now', '$user_id' )
            ";

        $message = 'ユーザの作成に成功しました';
    } else if ( $order == 'update' ) {
        // update   
        // この前にログインユーザの投稿かどうか判定する
        $query = "
            UPDATE posts SET 
                title = '$title',
                content = '$content',
                updated_at = '$now', 
            WHERE user_id = '$user_id'
            ";

        $message = 'ユーザ情報の編集に成功しました';
    } 

    query( $query );
    message_display( 'success', $message );
}   

function post_all() {
    $query = "
        SELECT * FROM posts 
        ORDER BY created_at DESC
        ";

    $result = query( $query );
    
    return $result;
}