<?php 

function h( $str ) {
    return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8');
}

function query( $query ) {
    $mysqli = get_db();

    $result = $mysqli->query( $query );

    if ( ! $result ) {
        print 'クエリが失敗しました' . "Errormessage: %s\n" . $mysqli->error;
        $mysqli->close();
        exit();
    }

    // insert文 delete文 update文
    if ( $result == true ) {
        // 結果セットを返さない場合
        $mysqli->close(); // データベース切断
    } else if ( mysqli_num_rows( $result ) > 1 ) {
        // select文
        // 結果セットが複数の場合は、全件取り出してから返す
        $result = $result->fetch_all();
    } 

    return $result;
}   

// テーブル名、カラム、値を指定してテーブルに、指定した値のレコードが存在するか判定
function isUniq( $table, $column, $value ) {

    $value = escape( $value );

    $query = "
        SELECT * FROM $table
        WHERE $column = '$value'
        ";

    $result = query( $query );

    if ( mysqli_num_rows( $result ) == 0  ) {
        return true;
    }

    return false;
}


function get_current_datetime() {
    $now = new DateTime();
    $now = $now->format('Y-m-d H:i:s');

    return $now;
}

function error_display( $errors ) {   
    foreach ( $errors as $error ) {
        ?>
        <div class="container">
            <div class="alert alert-dismissible alert-warning">
            <?php print h( $error ) ?>
            </div>
        </div>
        <?php
    }
}

function message_display( $type , $message ) {  
    ?>
    <div class="container">
        <div class="alert alert-dismissible alert-<?php print ( $type ) ?>">
        <?php print $message; ?>
        </div>
    </div>
    <?php
}