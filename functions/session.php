<?php 

session_start();
var_dump( $_SESSION );
var_dump( isAdmin() );
// 後に {Session Class} に吸収
// ログイン後、一定時間たったら自動ログアウトするようにしたい

function authenticate( $user_name, $email, $password ) 
{ 
    $mysqli = get_db();

    // Postデータをエスケープ
    $user_name = escape( $user_name );
    $email = escape( $email );
    $password = escape( $password );

    $query = " 
        SELECT * FROM users 
        WHERE username = '$user_name'
        AND email = '$email'
        ";  

    $result = $mysqli->query( $query );

    $errors = array();

    if ( mysqli_num_rows( $result ) == 0 ) {
        $errors[] = "ユーザ名かメールアドレスが間違っています"; // ログイン失敗

        require ( get_views_dir() . "/messages.php" ); 
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

    $result->close();

    // パスワードが妥当であるかを確認
    if ( password_verify( $password, $hashed_password ) ) { 
        session_set( 'user_id', $user_id );
        session_set( 'user_name', $user_name );
        session_set( 'email', $email );
        session_set( 'password', $password );
        session_set( 'created_at', $created_at );
        session_set( 'update_at', $update_at );
        session_id_regenerate();
        if ( $admin == 1 ) { 
            session_set( 'admin', 1 );
        }
        header( "Location: root.php" );
        exit;
    } else {    
        $errors[] = "パスワードが間違っています"; // ログイン失敗
        require ( get_views_dir() . "/messages.php" ); 
        return;
    }
}

// ログアウト
function signout() 
{
    session_clear();
    header( "Location: authenticate.php" );
}

function session_clear() 
{
    $_SESSION = array();
}

// セッション情報を格納
function session_get( $key ) 
{
    if ( isset( $_SESSION[$key] )  ) {
        return $_SESSION[$key];
    }
    
    return null;
}

// セッション情報を格納
function session_set( $key, $value ) 
{
    $_SESSION[$key] = $value;
}

// ログインしていればtrueを返却、していなければfalseを返却
function isAuthenticated() 
{
    if ( isset( $_SESSION['user_id'] ) ) {
        return true;
    }

    return false;
}

function isAdmin() 
{
    if ( isset( $_SESSION['admin'] ) ) {
        return true;
    }

    return false;
}

// 後で調べる
function session_id_regenerate()
{
    session_regenerate_id();
}

// ログイン必須のページにログインしないでアクセスしたとき、ログインページに戻す。
function require_authenticate()
{
    if ( ! isAuthenticated() ) {
        header( "Location: authenticate.php" );
        exit;
    }
}

function require_signout()
{
    if ( isAuthenticated() ) {
        header( "Location: root.php" );
        exit;
    }
}

// 一般ユーザがadmin 権限が必要なページにアクセスしたとき、ログインしていればホーム画面にそうでなければ、ログイン画面に戻す。
function require_adminAuthenticate()
{
    if ( ! isAdmin() ) {
        if ( isAuthenticated() ) {
            header( "Location: root.php" );
            exit;
        } else {
            header( "Location: authenticate.php" );
            exit;
        }
    }
}


function generateCsrfToken()
{

}

function checkCsrfToken()
{
    
}

