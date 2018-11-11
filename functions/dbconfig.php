<?php
// データベースの接続 ( 後にDbManagement Class の コンストラクタに吸収 )

function get_db() {
    static $mysqli;

    if ( ! $mysqli ) {
        $HOST = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DBNAME = "bulletin";

        $mysqli = new mysqli( $HOST, $USERNAME, $PASSWORD, $DBNAME );

        if ( $mysqli->connect_error ){
            print $mysqli->connect_error();
            exit;
        } else {
            $mysqli->set_charset( "utf8" );
        }
    }

    return $mysqli;
}


function escape( $str ) {
    $mysqli = get_db();

    return $mysqli->real_escape_string( $str );
}
