<?php 

// ここからfollow関連のfunction

function follow( $user_id ) {
    $user_id = escape( $user_id );
    $current_id = get_current_user_id();;

    if ( is_following( $user_id ) || is_Current_user( $user_id )
        || is_blocked( $other_id  ) ) {
        flash( 'フォローが失敗しました', 'danger' );
        redirect_back();
    }
 
    $query = "
        INSERT INTO followings (
            user_id, followed_id )
        VALUES (
            '$user_id','$current_id'
        ) ";

    if ( query( $query ) ) {
        flash( 'フォローに成功しました' );
        redirect_back();
    }
}

function unfollow( $user_id ) {
    $user_id = escape( $user_id );
    $current_id = get_current_user_id();;

    if ( ! is_following( $user_id ) || is_Current_user( $user_id ) ) {
        alert( 'danger' ,'unfollow failed' );
        return;
    }
 
    $query = "
        DELETE FROM followings 
        WHERE user_id = '$user_id'
        AND followed_id = '$current_id'
        ";

    if ( query( $query ) ) {
        flash( 'フォローを外しました' );
        redirect_back();
    }
}

function is_following( $user_id ) {
    $user_id = escape( $user_id );
    $current_id = get_current_user_id();
 
    $query = "
        SELECT * FROM followings
        WHERE user_id = '$user_id'
        AND followed_id = '$current_id'
        ";

    $result = query( $query );

    return $result['count'] == '1';
}

// 特定のユーザが自分自身をfollowしているか
function is_followed( $other_id ) {
    $other_id = escape( $other_id );
    $current_id = get_current_user_id();

    $query = "
        SELECT * FROM followings
        WHERE user_id = '$current_id'
        AND followed_id = '$other_id'
        ";

    $result = query( $query );

    return $result['count'] == '1';
}

// 特定のユーザから自分自身へのfollowを解除
function unfollowed_force( $other_id ) {
    $other_id = escape( $other_id );
    $current_id = get_current_user_id();

    if ( ! is_followed( $other_id ) || is_Current_user( $other_id ) ) {
        alert( 'danger' ,'failed' );
        return;
    }

    $query = "
        DELETE FROM followings 
        WHERE user_id = '$current_id'
        AND followed_id = '$other_id'
        ";

    if ( query( $query ) ) {
        flash( 'unfollowed successed' );
        redirect_back();
    }
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
function get_following_ids( $user_id = null ) {
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

// ここからblock機能のfunction

function block( $other_id ) {
    $other_id = escape( $other_id );
    $current_id = session_get( 'id' );

    if( is_block( $other_id  ) || is_Current_user( $other_id ) ) {
        flash( 'Block failed', 'danger' );
        redirect_back();
    }

    $query = "
        INSERT INTO block_relationships 
            ( blocked_user_id, block_user_id 
        ) VALUES 
            ( '$other_id', '$current_id' )    
    ";

    if ( query( $query ) ) {
        if ( is_following( $other_id ) ) {
            // 相手をfollowしている場合、解除する
            unfollow( $other_id );
        } 
        if ( is_followed( $other_id ) ) {
            // 相手にfollowされている場合、強制的にfollowを解除する
            unfollowed_force( $other_id );
        } 

        flash( 'block successed' );
        redirect_back();
    }
}

// ブロックを外す
function unBlock( $other_id ) {
    $other_id = escape( $other_id );
    $current_id = session_get( 'id' );

    if ( ! is_block( $other_id ) || is_Current_user( $other_id )) {
        flash( 'unBlock failed' , 'danger' );
        redirect_back();
    }

    $query = "
        DELETE FROM block_relationships 
        WHERE 
            blocked_user_id = '$other_id'
            AND
            block_user_id = '$current_id'
        ";
    
    if ( query( $query ) ) {
        flash( 'unBlock successed' );
        redirect_back();
    }
}

// ログインユーザが特定のユーザをブロックしているか
function is_block( $other_id ) {
    $other_id = escape( $other_id );
    $current_id = get_current_user_id();

    $query = "
        SELECT * FROM block_relationships 
        WHERE
            blocked_user_id = '$other_id'
            AND
            block_user_id = '$current_id' 
    ";

    $result = query( $query );

    return $result['count'] == '1'; 
}

function is_blocked( $other_id ) {
    $other_id = escape( $other_id );
    $current_id = get_current_user_id();
    
    $query = "
        SELECT * FROM block_relationships 
        WHERE
            blocked_user_id = '$current_id'
            AND
            block_user_id = '$other_id' 
    ";

    $result = query( $query );

    return $result['count'] == '1'; 
}