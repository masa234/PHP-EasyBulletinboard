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

        $user_id = session_get( 'user_id' );

        $query = "UPDATE users SET 
                    user_name = '$user_name',
                    nickname =  '$nickname',
                    email= '$email',
                    image = '$filename',
                    password = '$password'
                    WHERE id = '$user_id'
                ";

        $message = 'ユーザ情報の編集に成功しました';
    }
    
    query( $query );

    print $result['message'];
    message_display( 'success' ,  $message );
}

function user_delete( $user_id ) {

    $user_id = escape( $user_id );
    
    if ( is_Current_user( $user_id ) || ! is_Admin() ) {
        message_display( 'danger' , '管理者ではない、もしくは削除対象が自分自身です' );
        return;
    }

    $query = " 
        DELETE FROM `users` WHERE 
        id = '$user_id'
        ";

    query( $query );

    message_display( 'success' , 'ユーザの削除に成功しました' );
}

// ユーザのバリデーション（若干抜けてる部分があるかもしれません）
function user_validation( $user_name, $nickname, $email, $password ) {

    $errors = array();

    if ( ! mb_strlen( $user_name ) ) {
        $errors[] = "ユーザ名が空です";
    } else if ( is_numeric( $user_name ) ) {
        $errors[] = "ユーザ名は文字列でなくてはいけません";
    } else if ( mb_strlen( $user_name ) > 15 ) {
        $errors[] = "ユーザ名は15文字以内で入力してください";
    }

    if ( ! mb_strlen( $nickname ) ) {
        $errors[] = "nicknameが空です";
    } else if ( is_numeric( $nickname ) ) {
        $errors[] = "nicknameは文字列でなくてはいけません";
    } else if ( ( strpos( $nickname,' ' ) !== false ) ) {
        $errors[] = "nicknameは間に空白を挟んではいけません";      
    } else if ( ! preg_match( '/^(?=.*?[a-zA-Z])(?=.*?\d)[a-zA-Z\d]{5,15}$/', $nickname ) ) {
        $errors[] = "nicknameは半角英字と半角数字のみで両方を含む5文字以上15文字以内でなくてはいけません"; 
    } else if ( ! isUniq( 'users', 'nickname' , $nickname )
                && $nickname != session_get( 'nickname' ) ) {
        $errors[] = "nicknameが重複しています";
    }            

    if ( ! mb_strlen( $email ) ) {
        $errors[] = "emailが空です";
    } else if ( is_numeric( $email ) ) {
        $errors[] = "emailは文字列でなくてはいけません";
    } else if ( mb_strlen( $email ) > 255 ) {
        $errors[] = "emailは255文字以内で入力してください";
    }

    if ( ! mb_strlen( $password ) ) {
        $errors[] = "passwordが空です";
    } else if ( is_numeric( $password ) ) {
        $errors[] = "passwordは文字列でなくてはいけません";
    } else if ( ! preg_match( '/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{5,15}+\z/', $password ) ) {
        $errors[] = "passwordは半角英小文字大文字数字をそれぞれ1種類以上含む5文字以上15文字以下でお願いします";
    }

    return $errors;
}

// ログインユーザかどうか判定
function is_Current_user( $user_id ) {
    return session_get( 'user_id' ) == $user_id;
}

function is_Admin() {
    $user_id = session_get( 'user_id' );

    $query = "SELECT * FROM users 
            WHERE id ='$user_id'
            ";

    $mysqli = get_db();

    $result = $mysqli->query( $query );

    while ($row = $result->fetch_assoc()) {
        $admin = $row['admin'];
    }

    return $admin == '1';
}

function get_user( $user_id ) {

    $user_id = escape( $user_id );

    $query = "SELECT * FROM users 
        WHERE id = '$user_id'
        ";
    
    $mysqli = get_db();

    $result = $mysqli->query( $query );

    $user = array();

    while ( $row = $result->fetch_assoc() ) {
        $user['id'] = $row['id'];
        $user['user_name'] = $row['user_name'];
        $user["nickname"] = $row["nickname"];
        $user["email"] = $row["email"];
        $user["admin"] = $row["admin"];
        $user["image"] = $row["image"];
    }

    return $user;
}