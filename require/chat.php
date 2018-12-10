<?php

function startChat( $nickname ) {
    $nickname = escape( $nickname );
    if ( substr( $nickname, 0, 1 ) == '@' ){
        $nickname = ltrim( $nickname, '@' );
    }
    $other_user = find_by( 'users', $nickname, 'nickname' );

    if ( ! $other_user )  {
        flash( '入力されたnicknameのユーザが存在しません', 'danger' );
        redirect_back();
    } else if( isCurrent( 'users', $other_user['nickname'], 'nickname' ) ) {
        flash( '自分自身にメッセージを送信することはできません', 'danger' );
        redirect_back();
    }

    redirect( "room.php?id=" . get_current_user_id() . "&other_id". '='  . h( $other_user['id'] ) );
}

function speak( $content, $other_id ) {
    $content= escape( $content );
    $errors = content_validation( $content );
    
    if ( count( $errors ) > 0 ) {
        flash( $errors, 'danger' );
        redirect_back();
    }

    $user_id = get_current_user_id();

    $query = "
        INSERT INTO messages( 
            content, receive_user_id, writer_user_id
        ) VALUES (
            '$content', '$other_id', '$user_id'
        )";

    if ( query( $query ) ) {
        flash( '投稿に成功しました' ,'success' );
        redirect_back();
    }   
}

function content_validation( $content, $errors = null ) {
     if( ! is_array( $errors ) ) {
         $errors = array();
     }

     if ( ! mb_strlen( $content )
        || mb_strlen( $content ) > 140   ) {
            $errors = 'メッセージは1～140文字以内で入力してください';
        }

    return $errors;
}

function get_ChatMessages( $other_id ) {
    $user_id = get_current_user_id();
    $other_id = escape( $other_id );

    $query = "
        SELECT * FROM messages
        WHERE  
            ( receive_user_id = '$user_id' 
            AND
            writer_user_id = '$other_id' )
        OR  
            ( receive_user_id = '$other_id' 
            AND
            writer_user_id = '$user_id' )
        ";
        
    $result = query( $query );

    return $result['datas'];
}