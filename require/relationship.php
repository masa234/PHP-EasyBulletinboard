<?php 

function follow( $user_id ) {
    $user_id = escape( $user_id );
    $current_user_id = get_current_user_id();;

    if ( is_following( $user_id ) || is_Current_user( $user_id ) ) {
        flash( 'フォローが失敗しました', 'danger' );
        redirect_back();
    }
 
    $query = "
        INSERT INTO followings (
            user_id, followed_id )
        VALUES (
            '$user_id','$current_user_id'
        ) ";

    if ( query( $query ) ) {
        flash( 'フォローに成功しました' );
        redirect_back();
    }
}

function unfollow( $user_id ) {
    $user_id = escape( $user_id );
    $current_user_id = get_current_user_id();;

    if ( ! is_following( $user_id ) || is_Current_user( $user_id ) ) {
        message_display( 'danger' , '失敗しました' );
        return;
    }
 
    $query = "
        DELETE FROM followings 
        WHERE user_id = '$user_id'
        AND followed_id = '$current_user_id'
        ";

    if ( query( $query ) ) {
        flash( 'フォローを外しました' );
        redirect_back();
    }
}

function is_following( $user_id ) {
    $user_id = escape( $user_id );
    $current_user_id = get_current_user_id();;
 
    $query = "
        SELECT * FROM followings
        WHERE user_id = '$user_id'
        AND followed_id = '$current_user_id'
        ";
        var_dump( $query );

    $result = query( $query );

    return $result['count'] == '1';
}

// フォロワーの情報、フォローしているユーザの情報を配列で返します。
// カウントを取得したい場合は第三引数を指定する
function get_user_relationship_count( $type, $user_id ) {

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

function get_relationships_user( $type ,$user_id ) {
    $user_id = escape( $user_id );

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

// followしているユーザのIDを取得
function get_following_ids( $user_id = '333' ) {
    if ( ! $user_id ) {
        $user_id = get_current_user_id();
    } 

    $query ="
        SELECT * FROM followings
        WHERE 
        followed_id = '$user_id'
        ";

    $result = query( $query );
    $following_info = $result['datas'];

    if ( count( $following_info )> 0  ) {
        foreach( $following_info as $following ) {
            $following_ids[] = $following['user_id'];
        }
        return $following_ids;
    } 

    return $following_info;
}