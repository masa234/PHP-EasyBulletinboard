<?php

session_start();
session_regenerate_id();
$fname = basename( $_SERVER['PHP_SELF'] , ".php");


// ユーザ新規登録画面、ログイン画面のどちらかかつログアウトページでない場合
if ( $fname == 'authenticate' || $fname == 'register' ) {
    if ( isAuthenticated() ) {
        header( "Location: posts.php" );
        exit();
    } 
// ユーザ新規登録画面、ログイン画面以外
} else if ( ! isAuthenticated() ) { 
    // ログインしていない場合はログイン画面に遷移  
    header( "Location: authenticate.php" );
    exit();
} else {
    // ログインしている場合は、前回ログインからの時間が30分以上ならsessionを破棄する
    $now = strtotime("now");
    $session_last = session_get( 'session_created_at' );
    $elapsed_time = $now - $session_last;

    if( $elapsed_time > 1800 ){
        session_clear();
        print 'ログイン後、30分が経過したのでログアウトします お手数ですが、リロードして再度ログインをお願いいたします';
        exit();
    }
} 

function authenticate( $nickname, $password ) {

    $nickname = escape( $nickname );
    $password = escape( $password );

    $query = "
        SELECT * FROM users 
        WHERE nickname='$nickname'
        ";

    $result = query( $query );

    if ( mysqli_num_rows( $result ) == 0 ) {
        message_display( 'danger' , 'ログインに失敗しました' );
        return;
    }

    while ($row = $result->fetch_assoc()) {
        $user_id = $row['id'];
        $user_name = $row['user_name'];
        $nickname = $row['nickname'];
        $email = $row['email'];
        $image = $row['image'];
        $admin = $row['admin'];
        $db_password = $row['password'];
    }

    // データベースの切断
    $result->close();

    if ( password_verify( $password, $db_password ) ) {
        session_set( 'user_id', $user_id );
        session_set( 'user_name', $user_name );
        session_set( 'nickname', $nickname );
        session_set( 'email', $email );
        session_set( 'password', $db_password );
        session_set( 'admin', $admin );
        session_set( 'session_created_at', strtotime( 'now' ) );
        session_regenerate_id( true );
        header( "Location: posts.php" );
        exit;
    } else {
        message_display( 'danger' , 'ログインに失敗しました' );
    }
}

function session_set( $key, $value ) {
    $_SESSION[$key] = $value;    
}

function session_clear() {
    $_SESSION = array();
}

// ログインしていればtrueを返却、していなければfalseを返却
function isAuthenticated()
{
    return isset( $_SESSION['user_id'] );
}

function session_get( $key ) {
    return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
}