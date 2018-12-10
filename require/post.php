<?php 

function post_updateOrCreate( $order, $title, $content, $filename, $post_id = null  ) {
    $title = escape( $title );
    $content = escape( $content );

    $now = get_current_datetime();
    $user_id = get_current_user_id();
    
    $errors = post_validation( $title, $content, $post_id );

    if ( count( $errors ) > 0 ) {
        flash( $errors, 'warning' );
        redirect_back();
    }

    // create
    if ( $order == 'create' ) {
        $query = "
            INSERT INTO posts
                ( title, content, image, created_at, updated_at, user_id
            ) VALUES (
                '$title', '$content', '$filename', '$now', '$now', '$user_id' )
            ";

        $message = '新規投稿に成功しました';
    } else if ( $order == 'update' ) {
        if ( ! isCurrentUser( 'posts' ,$post_id ) ) {
            flash( '編集権限がありません', 'danger' );
            redirect( 'posts.php' );
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

    if ( query( $query ) ) {
        flash( $message );
        redirect_back();
    }
}   

function post_delete( $post_id ) {

    $post_id = escape( $post_id );
    
    if ( ! isCurrentUser( 'posts' ,$post_id ) ) {
        header( "Location: posts.php" );
        exit();
    }

    $user_id = get_current_user_id();

    $query ="
        DELETE FROM posts 
        WHERE id = '$post_id'
        AND user_id = '$user_id'
        ";

    if ( query( $query ) ) {
        flash( '削除に成功しました' );
        redirect_back();
    }
}

// updateの際は、引数にpostのidを指定する
function post_validation( $title, $content, $post_id = null ) {
    $errors = array();

    // updateの際は、編集する投稿の情報を先に取得する
    if ( $post_id ) {
        $post = find_by( 'posts' , $post_id );
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

function get_feed() {
    $user_id = get_current_user_id();
    $following_ids = get_following_ids();

    if ( $following_ids ) { 
        $following_ids = implode( ',', $following_ids );
        $or_retweet = "OR 
        retweets.user_id IN ( ".$following_ids . " ) ";
    } else {
        $or_retweet = null;
    }


    // 以下の条件に合致したpostを抽出する。
    // 1, 自分がフォローしているユーザの投稿
    // 2, 自分の投稿
    // 3, 自分がリツイートした投稿
    // 4, 自分がフォローしているユーザがリツイートした投稿
    $query = "
        SELECT 
            posts.id,
            posts.title,
            posts.content,
            posts.image,
            posts.created_at,
            posts.updated_at,
            posts.user_id,
            followings.followed_id,
            retweets.user_id as retweet_user_id
        FROM 
            posts LEFT JOIN followings
        ON  
            posts.user_id = followings.user_id
        LEFT JOIN retweets
        ON 
            posts.id = retweets.post_id
        WHERE 
            followings.followed_id= '$user_id'
        OR 
            posts.user_id = '$user_id'
        OR 
            ( retweets.user_id = '$user_id' 
            $or_retweet )
        GROUP BY
            posts.id
        ORDER BY 
            posts.updated_at DESC
        ";
        var_dump ( $query ); 
    
    $result = query( $query );

    return $result;
}

function get_post_value( $key, $post, $default = '' ) {
    if ( get_Post( $key ) ) {
        return get_Post( $key );
    } else if ( isset( $post ) && $post[$key] ) {
        return $post[$key];
    } else {
        return $default;
    }
}