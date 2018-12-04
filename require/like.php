<?php 

function like( $post_id ) {
    if ( is_liked( $post_id ) ) {
        message_display( 'danger' , '失敗しました' );
        return;
    }

    $user_id = get_current_user_id();
    $post_id = escape( $post_id );

    $query = "
        INSERT INTO likes ( 
            user_id , post_id 
        ) VALUES (
            '$user_id', '$post_id' )
        ";

    query( $query );

    message_display( 'success' , '投稿をいいねしました' );
}

function unlike( $post_id ) {
    if ( ! is_liked( $post_id ) ) {
        message_display( 'danger' , '失敗しました' );
        return;
    }

    $user_id = get_current_user_id();;
    $post_id = escape( $post_id );

    $query = "
        DELETE FROM likes 
        WHERE user_id = '$user_id'
        AND post_id = '$post_id'
        ";
    
    query( $query );

    message_display( 'success' , '投稿のいいねを外しました' );
}

function is_liked( $post_id ) {
    $user_id = get_current_user_id();;
    $post_id = escape( $post_id );

    $query = "
        SELECT * FROM likes
        WHERE user_id = '$user_id'
        AND post_id = '$post_id'
        ";

    $result = query( $query );

    return $result['count'] == 1;
}

// 第一引数にユーザのIDを指定してユーザのいいねの情報を配列で返却。
// 第二引数を指定した場合、userのLikeのカウントを返す 
function get_like_posts( $user_id, $count = false ) {
    $user_id = get_current_user_id();

    $query = "
        SELECT 
            posts.id,
            posts.title, 
            posts.content,
            posts.image,
            posts.created_at,
            posts.updated_at,
            likes.user_id
        FROM
            posts LEFT JOIN likes
        ON 
            posts.id = likes.post_id
        WHERE 
            likes.user_id = '$user_id'
        ";

    $result = query( $query );

    if ( $count ) {
        return $result['count'];
    }

    return $result['datas'];
}

// 前提条件として、userが削除されたときに、それに紐づくlikesテーブル、postsテーブルのレコードが削除されることが担保されていることが必須
function get_post_like_users( $post_id, $count = null ) {
    $post_id = escape( $post_id );

    $query ="
            SELECT 
                users.id as user_id, 
                posts.id as post_id,
                users.nickname,
                users.email,
                users.admin,
                users.image
            FROM 
                posts INNER JOIN users
            ON 
                posts.user_id = users.id 
            INNER JOIN 
                likes 
            ON 
                posts.id = likes.post_id 
            WHERE 
                post_id = '$post_id'
            ";

    $result = query( $query );

    if ( $count = 'count' ) {
        return $result['count'];
    }

    return $result['datas'];
}