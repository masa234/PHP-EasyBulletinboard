<?php 

function retweet( $post_id ) {
    $post_id = escape( $post_id );
    $user_id = get_current_user_id();

    if ( is_retweet( $post_id ) ) {
        flash( 'retweet successed', 'danger' );
        redirect_back();
    }

    $query = "
        INSERT INTO retweets 
            ( post_id, user_id ) 
        VALUES
            ( '$post_id', '$user_id' )
        ";

    if ( query( $query ) ) {
        flash( 'retweet successed' );
        redirect_back();
    }
}

function unRetweet( $post_id ) {
    $post_id = escape( $post_id );
    $user_id = get_current_user_id();

    if ( ! is_retweet( $post_id ) ) {
        flash( 'This post still not retweeted', 'danger' );
        redirect_back();
    }    

    $query = "
        DELETE FROM retweets 
        WHERE 
        post_id= '$post_id'
        AND
        user_id = '$user_id'
        ";

    if ( query( $query ) ) {
        flash( 'unretweet successed' );
        redirect_back();
    }
}

// ログインユーザが特定のpostをretweet済みか判定
function is_retweet( $post_id ) {
    $post_id = escape( $post_id );
    $user_id = get_current_user_id();

    $query = "
        SELECT * FROM retweets
        WHERE 
            post_id = '$post_id'
        AND 
            user_id = '$user_id'
        ";
    
    $result = query( $query );

    return $result['count'] == '1';
}

function get_post_retweeted_user( $post_id, $count = null ) {
    $post_id = escape( $post_id );

    $query ="
        SELECT 
            retweets.post_id as post_id,
            retweets.user_id as retweet_user_id,
            users.user_name,
            users.nickname
        FROM 
            users LEFT JOIN retweets
        ON  
            users.id = retweets.user_id  
        WHERE  
            retweets.post_id = '$post_id'
        GROUP BY
            retweets.user_id
        ";

    $result = query( $query );

    if ( $count = 'count' ) {
        return $result['count'];
    }

    return $result['datas'];
}
