<?php 

function h( $str ) {
    return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8');
}

function query( $query ) {
    $mysqli = get_db();

    $result = $mysqli->query( $query );
    var_dump( $query );

    if ( ! $result ) {
        print 'クエリが失敗しました' . "Errormessage: %s\n" . $mysqli->error;
        $mysqli->close();
        exit();
    }

    // insert文 delete文 update文
    if ( is_bool( $result ) && $result == true ) {
        // 結果セットを返さない場合
        $mysqli->close(); // データベース切断
    } 

    return $result;
}   

// ex: get_all( 'posts', 'updated_at', 'DESC' );
function get_all( $table, $column, $order ) {
    
    $query = "
        SELECT * FROM $table
        ORDER BY $column $order
        ";

    $result = query( $query );

    $datas = array();

    while ($row = $result->fetch_assoc()) {
        $datas[] = $row;
    }

    $result->close();
    
    return $datas;
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

function isCurrentUser( $table, $id ) {

    $id = escape( $id );
    $user_id = session_get( 'user_id' );

    $query ="
        SELECT * FROM $table
        WHERE id = '$id'
        AND user_id = '$user_id'
        ";

    $result = query( $query );

    if ( mysqli_num_rows( $result ) == 1 ) {
        $result->close();
        return true;
    }

    $result->close();
    return false;
}


function get_current_datetime() {
    $now = new DateTime();
    $now = $now->format('Y-m-d H:i:s');

    return $now;
}

function image_upload( $files ) {
    $extension = substr( mime_content_type( $files["tmp_name"] ) , 6 ); // ファイルの拡張子
    var_dump( $extension );
    list( $vertical, $holizontal ) = getimagesize( $files["tmp_name"] );

    try {
        // フォーム改ざん時、発生するエラーを探知
        if ( ! isset( $files['error'] ) || !is_int( $files['error'] ) ) {
            throw new Exception('パラメータが不正です');
        } switch ( $files['error'] ) {
            case UPLOAD_ERR_OK: // OK
                break;
            case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                throw new Exception('ファイルが選択されていません');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new Exception( 'ファイルサイズが大きすぎます' );
            default:
                throw new Exception( 'その他のエラーが発生しました' );
        }

        if ( ! $ext = array_search( 
            $extension,
            array( 'gif', 'jpeg', 'png',
             )
        )) {
            throw new Exception( 'ファイルの形式エラーです' );
        }

        if ( $vertical > 600 || $holizontal > 600 ) {
            throw new Exception( '画像が大きすぎます' );
        }


        if ( ! file_exists( '../images' ) ) {
            mkdir( '../images' );
        }

        $filename = date( 'YmdHis' ) . sha1( true ) . '.' . $extension;

        if ( move_uploaded_file ( $_FILES["image"]["tmp_name"], "../images/" . $filename ) ) {
            chmod( '../images/' . $filename , 0644 );
            return $filename;
        }
    } catch (Exception $e) {
        message_display( 'danger',  $e->getMessage() );
        return null; // アップロードに失敗したためfilepathはnull
    }
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