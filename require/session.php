<?php

session_start();
session_regenerate_id();
$current = get_current();

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
        alert( 'danger', '失敗しました' ); 
        return;
    }
    $datas = $result['datas'];

    // パスワードが妥当であるかを確認
    if ( password_verify( $password, $datas['password'] ) ) {
        session_set_array( $datas );
        session_set( 'session_created_at', strtotime( 'now' ) );
        flash( 'ログインに成功しました', 'success' );
        redirect( 'posts.php' );
    } else {
        alert( 'danger', '失敗しました' );
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

function session_get( $key, $default = null ) {
    return isset( $_SESSION[$key] ) ? $_SESSION[$key] : $default;
}

function session_remove( $key ) {
    unset( $_SESSION[$key] );
}

function session_clear() {
    $_SESSION = array();
}

// ログインしていればtrueを返却、していなければfalseを返却
function isAuthenticated() {
    return isset( $_SESSION['id'] );
}

function redirect( $path ) {
    header( "Location:" .  $path );
    exit(); 
}

function redirect_back() {
    $referrer =  isset( $_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : 'posts.php';
    header( 'Location: ' . $referrer );
    exit();
}
function flash( $object, $type = 'success' ) {
    $_SESSION['flash'][$type] = $object;
}

// navbar.phpの内部でこのfunctionを実行。
// sessionのflashにデータが格納している場合、その値のアラート表示。
function flash_display() {
    if( $flashes = session_get( 'flash' ) ) {
        foreach( $flashes as $type => $object ) {
            if ( ! is_array( $object ) ) {
                alert( $type, $object );
            } else {
                error_display( $object );
            }
        }
    }
    session_remove( 'flash' );
}