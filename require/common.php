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
    if ( is_bool( $result ) && $result == true ) {
        // 結果セットを返さない場合
        $mysqli->close(); // データベース切断
    } 

    return $result;
}   

function pagination( $table, $column ,$order, $limit, $where = null ) {

    if ( isset( $_REQUEST['page'] ) ) {
        if ( ! is_numeric( $_REQUEST['page'] ) ) {
            // string型
            message_display( 'danger', 'pageパラメータは数値を指定してください' );
            exit();
        } else {
            $page = $_REQUEST['page'];
        }
    } else {
        $page =1;
    }

    $query = "
	        SELECT *
	        FROM $table
            ";

    $result = query( $query );

    $data_count = mysqli_num_rows( $result );

    if ( $data_count == 0 ) {
        return array(); // データが存在しない場合は空の配列を返す
    }

    $page_count = ceil( $data_count / $limit );

    if ( $page > 0  && $page <= $page_count  ) {
        $start = ( $page * $limit ) - $limit; 
    } else {
        message_display( 'warning', $page . 'ページ目は存在しなかったので1ページ目を表示しています' );
        $start = 0;
    }
    ?>

    <?php if ( $page > 1 ): ?>
    <ul class="pagination pagination-lg">
        <?php for ( $i=1; $i <= $page_count; $i++ ): ?>
            <?php if ( $i != $page ): ?>
            <li class="page-item">
            <?php else: ?>
            <li class="page-item disabled">
            <?php endif; ?>
                <a class="page-link" href="?page=<?php print $i ?>"><?php print $i; ?></a>
            </li>
        <?php endfor; ?> 
    </ul>
    <?php endif; ?>
    <?php 

    $query = "
        SELECT  *
        FROM $table
        $where
        ORDER BY $column $order
        LIMIT $start, $limit
        ";
        var_dump( $query );

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
        $result->close();
        return true;
    }

    $result->close();
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
    list( $vertical, $holizontal ) = getimagesize( $files["tmp_name"] );

    try {
        // フォーム改ざん時、発生するエラーを探知
        if ( ! isset( $files['error'] ) || !is_int( $files['error'] ) ) {
            throw new RuntimeException('パラメータが不正です');
        } switch ( $files['error'] ) {
            case UPLOAD_ERR_OK: // OK
                break;
            case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                throw new RuntimeException('ファイルが選択されていません');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException( 'ファイルサイズが大きすぎます' );
            default:
                throw new RuntimeException( 'その他のエラーが発生しました' );
        }

        if ( ! $ext = array_search( 
            $extension,
            array( 'gif', 'jpeg', 'png',
             )
        )) {
            throw new RuntimeException( 'ファイルの形式エラーです' );
        }

        if ( $vertical > 600 || $holizontal > 600 ) {
            throw new RuntimeException( '画像が大きすぎます' );
        }

    } catch (RuntimeException $e) {
        message_display( 'danger',  $e->getMessage() );
        return;
    }

    if ( ! file_exists( '../images' ) ) {
        mkdir( '../images' );
    }

    $filename = date( 'YmdHis' ) . sha1( true ) . '.' . $extension;

    if ( move_uploaded_file ( $files["tmp_name"], "../images/" . $filename ) ) {
        chmod( '../images/' . $filename , 0644 );
        return $filename;
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
        <?php print h( $message ); ?>
        </div>
    </div>
    <?php
}
