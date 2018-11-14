<?php 

function post_register( $title, $content ) {
    post_insertOrUpdate( 'insert' , $title, $content );
}

function post_insertOrUpdate( $order, $title, $content, $post_id =null ) {

    $title = escape( $title );
    $content = escape( $content );

    $now = get_current_datetime();
    $user_id = session_get( 'user_id' );
    
    $errors = post_validation( $title, $content, $post_id );

    if ( count( $errors ) > 0 ) {
        error_display( $errors );
        return;
    }

    // create
    if ( $order == 'insert' ) {
        $query = "
            INSERT INTO posts
                ( title, content, created_at, updated_at, user_id
            ) VALUES (
                '$title', '$content', '$now', '$now', '$user_id' )
            ";

        $message = '新規投稿に成功しました';
    } else if ( $order == 'update' ) {

        if ( ! isCurrentUserPost( $post_id ) ) {
            header( "Location: posts.php" );
            exit(); 
        }

        $query = "
        UPDATE posts SET 
            title = '$title',
            content = '$content',
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

    if ( ! mb_strlen( trim( $title ) ) ) {
        $errors[] = "タイトルが空です";
    } else if ( mb_strlen( trim( $title ) ) > 30 ) {
        $errors[] = "タイトルは30文字以内で入力してください";
    } else if ( ! isUniq( 'posts', 'title', trim( $title ) ) // 第一条件は、入力したタイトルが一意の場合,true
                && $title != $post['title'] ) { // 第二条件はinsert時は常にtrue, update時は編集するpostとタイトルを指定した場合true
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

function post_all() {

    
    $query = "
        SELECT * FROM posts 
        ORDER BY created_at DESC
        ";

    $result = query( $query );

    $posts = array();

    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    $result->close();
    
    return $posts;
}

function post_edit( $post_id ) {
    
    if ( ! isCurrentUserPost( $post_id ) ) {
        header( "Location: posts.php" );
        exit();
    }

    $post = get_post( $post_id );

    return $post;
}

function get_post( $post_id ) {
    $post_id = escape( $post_id );

    $query = "SELECT * FROM posts 
        WHERE id = '$post_id'
        ";
    
    $result = query( $query );

    $post = array();

    while ( $row = $result->fetch_assoc() ) {
        $post['id'] = $row['id'];
        $post['title'] = $row['title'];
        $post["content"] = $row["content"];
        $post["created_at"] = $row["created_at"];
        $post["updated_at"] = $row["updated_at"];
        $post["user_id"] = $row["user_id"];
    }

    return $post;
}

function post_delete( $post_id ) {

    $post_id = escape( $post_id );
    
    if ( ! isCurrentUserPost( $post_id ) ) {
        header( "Location: posts.php" );
        exit();
    }

    $user_id = session_get( 'user_id' );

    $query ="
        DELETE FROM posts 
        WHERE id = '$post_id'
        AND user_id = '$user_id'
        ";

    query( $query );

    message_display( 'success', '削除に成功しました' );
}

function isCurrentUserPost( $post_id ) {

    $post_id = escape( $post_id );
    $user_id = session_get( 'user_id' );

    $query ="
        SELECT * FROM posts
        WHERE id = '$post_id'
        AND user_id = '$user_id'
        ";

    $result = query( $query );

    if ( mysqli_num_rows( $result ) == 1 ) {
        $result->close();
        return true;
    }

    $result->close();
    return false;
}