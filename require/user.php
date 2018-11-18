<?php

function user_insertOrUpdate( $order ,$user_name, $nickname, $email, $password, $filename ) {
    // データをエスケープ
    $user_name = escape( $user_name );
    $nickname = escape( $nickname );
    $email = escape( $email );
    $password = escape( $password );

    $errors = user_validation( $user_name, $nickname, $email, $password );

    if ( count( $errors ) > 0 ) {
        error_display( $errors );
        return;
    }

    $password = password_hash( $password, PASSWORD_DEFAULT ); // password hash化

    if ( $order == 'insert' ) {

        $query = "INSERT INTO users 
                    ( user_name, nickname, email, image, password 
                ) VALUES (
                    '$user_name', '$nickname', '$email', '$filename', '$password'
                )";

        $message = 'ユーザの作成に成功しました';

    } else if ( $order == 'update' ) {

        $query = "UPDATE users SET 
                    user_name = '$user_name',
                    nickname =  '$nickname',
                    email= '$email',
                    image = '$image',
                    password = '$password',
                    WHERE id = '$user_id'
                ";

        $message = 'ユーザ情報の編集に成功しました';
    }
    
    query( $query );

    message_display( 'success' , 'ユーザの作成に成功しました' );
}

// ユーザのバリデーション（若干抜けてる部分があるかもしれません）
function user_validation( $user_name, $nickname, $email, $password ) {

    $errors = array();

    if ( ! mb_strlen( trim( $user_name ) ) ) {
        $errors[] = "ユーザ名が空です";
    } else if ( mb_strlen( trim( $user_name ) ) > 15 ) {
        $errors[] = "ユーザ名は15文字以内で入力してください";
    } else if ( is_numeric( $user_name ) ) {
        $errors[] = "ユーザ名は文字列でなくてはいけません";
    }

    if ( ! mb_strlen( $nickname ) ) {
        $errors[] = "nicknameが空です";
    } else if ( mb_strlen( trim( $nickname ) ) > 15 ) {
        $errors[] = "nicknameは15文字以内で入力してください";
    } else if ( ! isUniq( 'users', 'nickname' , $nickname )
                && $nickname != session_get( 'nickname' ) ) {
        $errors[] = "nicknameが重複しています";
    } else if ( is_numeric( $nickname ) ) {
        $errors[] = "nicknameは文字列でなくてはいけません";
    }

    if ( ! mb_strlen( $email ) ) {
        $errors[] = "emailが空です";
    } else if ( mb_strlen( trim( $email ) ) > 255 ) {
        $errors[] = "emailは255文字以内で入力してください";
    } else if ( is_numeric( $email ) ) {
        $errors[] = "emailは文字列でなくてはいけません";
    }

    if ( ! mb_strlen( $password ) ) {
        $errors[] = "passwordが空です";
    } else if ( ! preg_match( '/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{5,15}+\z/', trim( $password ) ) ) {
        $errors[] = "passwordは半角英小文字大文字数字をそれぞれ1種類以上含む5文字以上15文字以下でお願いします";
    } else if ( is_numeric( $password ) ) {
        $errors[] = "passwordは文字列でなくてはいけません";
    }

    return $errors;
}
