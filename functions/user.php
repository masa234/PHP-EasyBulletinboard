<?php 

// 後に {User Class} に吸収

// 登録処理
function register( $user_name, $email, $password ) 
{ 
    $mysqli = get_db();
    
    $errors = user_validation( $user_name, $email, $password );

    if ( count( $errors ) == '0' ) {
        user_insert( $user_name, $email, $password );
    }

    require ( get_views_dir() . "/messages.php" ); 
 }

// ユーザテーブルにレコードを追加
function user_insert( $user_name, $email, $password ) 
{
    $mysqli = get_db();

    // Postデータをエスケープ
    $user_name = escape( $user_name );
    $email = escape( $email );
    $password = escape( $password );
    $password = password_hash( $password, PASSWORD_DEFAULT ); // password hash化
    $admin = 0; // 一般ユーザは0
    $now = new DateTime();
    $current_time = $now->format('Y-m-d H:i:s');

    $query = "INSERT INTO users( 
                    username, email, password, admin, created_at, update_at 
            ) VALUES ( 
                    '$user_name', '$email', '$password', '$admin', '$current_time', '$current_time' 
            )";

    if( $mysqli->query( $query ) ) {  
        $success_message = "ユーザの作成に成功しました";
    } else { 
        printf("Errormessage: %s\n", $mysqli->error); 
    }

    require ( get_views_dir() . "/messages.php" ); 
}


// validation エラー情報をerror配列で返却
function user_validation( $user_name, $email, $password ) 
{
    $mysqli = get_db();

    $errors = array();

    // validationチェック

    // user_name ：空白NG ,15文字以内
    if ( ! strlen( $user_name ) ) {
        $errors[] = "ユーザ名が空白です";
    } else if ( strlen( $user_name ) > 15 ) {
        $errors[] = "ユーザ名は15文字以内でお願いします";
    } else if  ( ! isUniqueUserName( $user_name ) 
                && ! session_get( 'user_name' ) ) { // ログインユーザの名前でなく、ユーザ名が一意でないとき
        $errors[] = "ユーザ名は既に使われています";
    }

    // email ：空白NG ,255文字以内
    if ( ! strlen( $email ) ) {
        $errors[] = "メールアドレスが空白です";
    } else if ( strlen( $email ) > 255 ) {
        $errors[] = "メールアドレスは255文字以内でお願いします";
    } 

    // password ：空白NG ,5～15文字以内
    if ( ! strlen( $password ) ) {
        $errors[] = "passwordが空白です";
    } else if ( strlen( $password ) < 5 
                ||  strlen( $password ) > 15  ) {
        $errors[] = "passwordは5～15文字以内でお願いします";
    } 

    return $errors;
}

function isUniqueUserName( $user_name )
{
    $mysqli = get_db();

    $user_name = escape( $user_name ); 

    // 与えられたユーザ名を持つユーザをusersテーブルから抽出
    $query = " 
        SELECT * FROM users 
        WHERE username = '$user_name'
        ";

    $result = $mysqli->query( $query );

    if ( mysqli_num_rows( $result ) ==  0 ) {
        return true; // ユーザ名が一意なのでtrueを返却
    }
    
    return false;
}   

// 更新処理
function user_update( $user_name, $email, $password ) 
{ 
    $mysqli = get_db();

    $errors = user_validation( $user_name, $email, $password );

    if ( count( $errors ) == '0' ) {
        // Postデータをエスケープ
        $user_name = escape( $user_name );
        $email = escape( $email );
        $password = escape( $password );
        $password = password_hash( $password, PASSWORD_DEFAULT ); // password hash化
        $now = new DateTime();
        $current_time = $now->format('Y-m-d H:i:s');

        $user_id = session_get( 'user_id' );

        $query = "
            UPDATE `users` 
            SET
                `username` = '$user_name', 
                `email`= '$email',
                `password`= '$password',
                `update_at`= '$current_time'
            WHERE id = '$user_id'
            ";

        $result = $mysqli->query( $query );

        if ( ! $result ) {
            print "クエリが失敗しました";
            return;
        }
        
        set_current_user();
        $success_message = "ユーザ情報の更新が完了しました";
    }

    require ( get_views_dir() . "/messages.php" ); 
}

// 後で名前変えます（ 関数名に違和感があるので ）
function set_current_user() 
{ 
    $mysqli = get_db();

    $current_user_id = session_get( 'user_id' );

    $query = "SELECT * FROM users 
            WHERE id = '$current_user_id'
            ";

    $result = $mysqli->query( $query );

    if ( ! $result ) {
        print "クエリが失敗しました";
        return;
    }

    while ( $row = $result->fetch_assoc() ) {
        $user_id = $row['id'];
        $user_name = $row['username'];
        $email = $row['email'];
        $hashed_password = $row['password'];
        $admin = $row['admin'];
        $created_at = $row['created_at'];  
        $update_at = $row['update_at'];  
    }

    session_set( 'user_id', $user_id );
    session_set( 'user_name', $user_name );
    session_set( 'email', $email );
    session_set( 'password', $hashed_password );
    session_set( 'created_at', $created_at );
    session_set( 'update_at', $update_at );
}

function user_all()
{   
    $mysqli = get_db();

    $query = "
        SELECT * FROM users
        ";

    $result = $mysqli->query( $query );

    $users = array();

    while ( $user = $result->fetch_assoc() ) {
        $users[] = $user;
    }

    return $users;
}

function user_delete( $id )
{   
    $mysqli = get_db();

    $id = escape( $id );

    if ( isCurrent_user( $id ) ) {
        header( "Location: users.php" );
        exit;
    } 

    $query = "
        DELETE FROM users WHERE id = '$id'
        ";

    $result = $mysqli->query( $query );

    if ( $result ) {
        $success_message = "削除に成功しました";
    } 

    require ( get_views_dir() . "/messages.php" );
}

// ログインユーザかどうか判定
function isCurrent_user( $id ) {
    $mysqli = get_db();

    $id = escape( $id );

    return  session_get( 'user_id' ) == $id;
}

function getGravatarUrl( $email, $size = 100 ) 
{   
    $gravatar_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) .  "&s=" . $size;

    return $gravatar_url;
}