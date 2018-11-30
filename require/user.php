<?php

function user_insertOrUpdate( $order ,$user_name, $nickname, $email, $password, $filename ) {

    // データをエスケープ
    $user_name = escape( $user_name );
    $nickname = escape( $nickname );
    $email = escape( $email );
    $password = escape( $password );  

    $errors = user_name_validation( $user_name );
    $errors = user_nickname_validation( $nickname, $errors );
    $errors = user_email_validation( $email, $errors );
    $errors = user_password_validation( $password, $errors );

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
        
        if ( query( $query ) ) {
            $query = "
            SELECT * FROM users 
            WHERE nickname='$nickname'
            ";

            if ( $result = query( $query, 'fetch' ) ) {
                $datas = $result['datas'];
                session_set_array( $datas );
                session_set( 'session_created_at', strtotime( 'now' ) );
                header( "Location: posts.php" );
                exit();
            }
        }
    } else if ( $order == 'update' ) {
        $user_id = get_current_user_id();

        $query = "UPDATE users SET 
                    user_name = '$user_name',
                    nickname =  '$nickname',
                    email= '$email',
                    image = '$filename',
                    password = '$password'
                    WHERE id = '$user_id'
                ";

        if ( query( $query ) ) {
            set_current_user();
            message_display( 'success', 'ユーザ情報の編集に成功しました' ); 
        }
    }
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

    if ( query( $query ) ) {
        message_display( 'success' , 'ユーザの削除に成功しました' );
    }
}

function user_name_validation( $user_name, $errors = null ) {
    if ( ! is_array ( $errors ) ) {
        $errors = array();
    }

    if ( ! mb_strlen( $user_name ) ) {
        $errors[] = "ユーザ名が空です";
    } else if ( is_numeric( $user_name ) ) {
        $errors[] = "ユーザ名は文字列でなくてはいけません";
    } else if ( mb_strlen( $user_name ) > 20 ) {
        $errors[] = "ユーザ名は20文字以内で入力してください";
    }

    return $errors;
}

function user_nickname_validation( $nickname, $errors = null ) {
    if ( ! is_array ( $errors ) ) {
        $errors = array();
    }

    if ( ! mb_strlen( $nickname ) ) {
        $errors[] = "nicknameが空です";
    } else if ( is_numeric( $nickname ) ) {
        $errors[] = "nicknameは文字列でなくてはいけません";      
    } else if ( ! preg_match( '/^(?=.*?[a-zA-Z])(?=.*?\d)[a-zA-Z\d]{5,20}$/', $nickname ) ) {
        $errors[] = "nicknameは半角英字と半角数字のみで両方を含む5文字以上20文字以内でなくてはいけません"; 
    } else if ( ! isUniq( 'users', 'nickname' , $nickname )
                && $nickname != session_get( 'nickname' ) ) {
        $errors[] = "nicknameが重複しています";
    }         

    return $errors;
}

function user_email_validation( $email, $errors = null ) {
    if ( ! is_array ( $errors ) ) {
        $errors = array();
    }

    if ( ! mb_strlen( $email ) ) {
        $errors[] = "emailが空です";
    } else if ( is_numeric( $email ) ) {
        $errors[] = "emailは文字列でなくてはいけません";
    } else if ( mb_strlen( $email ) > 255 ) {
        $errors[] = "emailは255文字以内で入力してください";
    }

    return $errors;
}

function user_password_validation( $password, $errors = null ) {
    if ( ! is_array ( $errors ) ) {
        $errors = array();
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

// 後で名前変えます（ 関数名に違和感があるので ）
function set_current_user() {
    $current_user_id = get_current_user_id();
    $current_user_info = find( 'users' ,$current_user_id );
    var_dump( $current_user_info );

    session_set_array( $current_user_info );
}

// ログインユーザかどうか判定
function is_Current_user( $user_id ) {
    return session_get( 'id' ) == $user_id;
}

function is_Admin() {
    return session_get( 'admin' ) == '1';
}

function get_user_value( $key ) {
    return get_Post( $key ) ? get_Post( $key ) : session_get( $key );
}