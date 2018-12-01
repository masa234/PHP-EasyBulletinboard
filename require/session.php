<?php

session_start();
session_regenerate_id();
$current = basename( $_SERVER['SCRIPT_NAME'] ,'.php' );

// ユーザ新規登録画面、ログイン画面のどちらかかつログアウトページでない場合
if ( $current == 'authenticate' || $current == 'register' ) {
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

    // if( $elapsed_time > 1800 ){
    //     session_clear();
    //     print 'ログイン後、30分が経過したのでログアウトします お手数ですが、リロードして再度ログインをお願いいたします';
    //     exit();
    // }
} 

function authenticate( $nickname, $password ) {
    $nickname = escape( $nickname );
    $password = escape( $password );

    $query = "
        SELECT * FROM users 
        WHERE nickname='$nickname'
        ";

    $result = query( $query, 'fetch' );

    if ( $result['count'] == 0 ) {
        message_display( 'danger', 'ユーザ名が間違っています' );
        return;
    }
    $datas = $result['datas'];

    // パスワードが妥当であるかを確認
    if ( password_verify( $password, $datas['password'] ) ) {
        session_set_array( $datas );
        session_set( 'session_created_at', strtotime( 'now' ) );
        header( "Location: posts.php" );
        exit();
    } else {
        message_display( 'danger', 'ログインに失敗しました' );
    }
}

function session_set( $key, $value ) {
    $_SESSION[$key] = $value;    
}

function session_set_array( $datas ) {
    foreach ( $datas as $key => $value ) {
        $_SESSION[$key] = $value;
    }
}

function session_get( $key ) {
    return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
}

function session_clear() {
    $_SESSION = array();
}

// ログインしていればtrueを返却、していなければfalseを返却
function isAuthenticated() {
    return isset( $_SESSION['id'] );
}
