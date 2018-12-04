<?php 

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

function retweet( $post_id ) {
    $post_id = escape( $post_id );
    $user_id = get_current_user_id();

    if ( is_retweet( $post_id ) ) {
        message_display( 'danger', 'This post allready retweeted' );
        return;
    }

    $query = "
        INSERT INTO retweets 
            ( post_id, user_id ) 
        VALUES
            ( '$post_id', '$user_id' )
        ";

    if ( query( $query ) ) {
        message_display( 'success', 'retweet successed' );
    }
}

function unRetweet( $post_id ) {
    $post_id = escape( $post_id );
    $user_id = get_current_user_id();

    if ( ! is_retweet( $post_id ) ) {
        message_display( 'danger', 'This post still not retweeted' );
        return;
    }    

    $query = "
        DELETE FROM retweets 
        WHERE 
        post_id= '$post_id'
        AND
        user_id = '$user_id'
        ";
        var_dump( $query );

    if ( query( $query ) ) {
        message_display( 'success', 'unretweet successed' );
    }
}

function get_post_retweet_user( $post_id, $count ) {

}