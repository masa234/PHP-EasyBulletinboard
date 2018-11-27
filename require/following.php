<?php 

function is_following( $user_id ) {

    $user_id = escape( $user_id );
    $current_user_id = session_get( 'user_id' );
 
    $query = "
        SELECT * FROM followings
        WHERE user_id = '$user_id'
        AND followed_id = '$current_user_id'
        ";

    $result = query( $query );

    return $result['count'] == '1';
}

function follow( $user_id ) {

    $user_id = escape( $user_id );
    $current_user_id = session_get( 'user_id' );

    if ( is_following( $user_id ) || is_Current_user( $user_id ) ) {
        message_display( 'danger' , '失敗しました' );
        return;
    }
 
    $query = "
        INSERT INTO followings (
            user_id, followed_id )
        VALUES (
            '$user_id','$current_user_id'
        ) ";

    query( $query );

    message_display( 'success' , 'フォローに成功しました' );
}

function unfollow( $user_id ) {

    $user_id = escape( $user_id );
    $current_user_id = session_get( 'user_id' );

    if ( ! is_following( $user_id ) || is_Current_user( $user_id ) ) {
        message_display( 'danger' , '失敗しました' );
        return;
    }
 
    $query = "
        DELETE FROM followings 
        WHERE user_id = '$user_id'
        AND followed_id = '$current_user_id'
        ";

    query( $query );

    message_display( 'success' , 'フォロー解除に成功しました' );
}

// フォロワーの情報、フォローしているユーザの情報を配列で返します。
// カウントを取得したい場合は第三引数を指定する
function get_relationship_count( $type, $user_id ) {

    $user_id = escape( $user_id );

    if ( $type == 'follower' ) {
        $query = "
            SELECT * FROM followings 
            WHERE user_id = '$user_id'
            ";
    } else if ( $type == 'following' ) {
        $query = "
            SELECT * FROM followings 
            WHERE followed_id = '$user_id'
            ";
    }

    $result = query( $query );

    return $result['count'];
}

function get_relationships( $type ,$user_id ) {

    $user_id = escape( $user_id );
    $current_user_id = session_get( 'user_id' );

    if ( $type == 'follower' ) {
        // ON は連結条件
        // WHERE は抽出条件
        $query = "
                SELECT  
                    *                
                FROM 
                    users LEFT JOIN followings
                ON  
                    followings.followed_id= users.id
                WHERE 
                    followings.user_id= '$user_id'
                ";

    } else if ( $type == 'following' ) {
        // ON は連結条件
        // WHERE は抽出条件
        $query = "
                SELECT  
                    *                
                FROM 
                    users RIGHT JOIN followings
                ON  
                    followings.user_id= users.id
                WHERE 
                    followings.followed_id = '$user_id'
                ";
    }

    $result = query( $query );

    return $result['datas'];
}