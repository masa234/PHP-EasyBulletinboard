<?php
// データベースの接続 ( 後にDbManagement Class の コンストラクタに吸収 )
error_reporting(E_ALL);
ini_set('display_errors', '1');


function get_db() {
    static $mysqli;

    $HOST = "localhost";
    $USERNAME = "root";
    $PASSWORD = "";
    $DBNAME = "bulletinboard";
    
    $mysqli = new mysqli( $HOST, $USERNAME, $PASSWORD, $DBNAME );

    if ( $mysqli->connect_error ){
        print $mysqli->connect_error();
        exit;
    } else {
        $mysqli->set_charset( "utf8" );
    }

    return $mysqli;
}


function escape( $str ) {
    $mysqli = get_db();

    return $mysqli->real_escape_string( trim( $str ) );
}

