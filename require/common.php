<?php 

function h( $str ) {
    return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8');
}

// query メソッド、デフォルトで連想配列を返却する
function query( $query, $type = null ) {
    global $mysqli;

    $result = $mysqli->query( $query );
    dump( $query );

    if ( $result === false ) {
        // クエリ失敗 
        message_display( 'danger', "クエリが失敗しましたMySQL error" . $mysqli->error  );
        exit();
    } else if ( $result === true ) {

        $response = array(
            'count'  => $mysqli->affected_rows, 
            'datas' => '',
            'message' => 'query success',
        );
    } else {

        $datas = array();

        if ( $type == 'fetch' ) {
            while ( $row = $result->fetch_assoc() ) {
                foreach( $row as $key => $value ) {
                    $datas[$key] = $row[$key];
                }
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $datas[] = $row;
            }
        }

        $response = array(
            'count'  => mysqli_num_rows( $result ), 
            'datas' => $datas,
            'message' => 'query success',
        );
        
        $result->close();
    }

    if ( $type == 'json' ) {
        return json_encode( $response['datas'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
    } else {
        return $response;
    }
}    

function find( $table ,$id ) {
    $id = escape( $id );

    $query = "
        SELECT * FROM $table
        WHERE id = '$id'
        ";

    $result = query( $query, 'fetch' );

    return $result['datas'];
}

// テーブル名、カラム、値を指定してテーブルに、指定した値のレコードが存在するか判定
function isUniq( $table, $column, $value ) {

    $value = escape( $value );

    $query = "
        SELECT * FROM $table
        WHERE $column = '$value'
        ";

    $result = query( $query );

    return $result['count'] == 0;
}

function isCurrentUser( $table, $id ) {

    $id = escape( $id );
    $user_id = get_current_user_id();

    $query ="
        SELECT * FROM $table
        WHERE id = '$id'
        AND user_id = '$user_id'
        ";

    $result = query( $query );

    return $result['count'] == 1;
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

function get_Get( $key ) {
    return ( string )filter_input( INPUT_GET, $key );
}

function get_Post( $key ) {
    return ( string )filter_input( INPUT_POST, $key );
}

function get_current() {
    return basename( $_SERVER['SCRIPT_NAME'] ,'.php' );
}

function get_current_user_id() {
    return session_get( 'id' );
}

function get_current_datetime() {
    $now = new DateTime();
    $now = $now->format('Y-m-d H:i:s');

    return $now;
}

function is_Submit( $key = 'action' ) {
    return isset( $_POST[$key] ) && ! is_array( $_POST[$key] );
}   

// ここから出力系のfunction

function require_foreach( $datas, $each_var ,$path ) {
    if ( count( $datas ) > 0 ) {
        foreach ( $datas as ${$each_var} ) {
            require ( $path );
        }
    } else {
        print 'データなし';
        exit();
    }
}

function error_display( $errors ) { 
    ?><div class="container">
          <div class="alert alert-dismissible alert-warning">
          <?= h ( count( $errors ) . '件のエラーが発生しました' ) ?><br>
          <?php foreach ( $errors as $error ): ?>
          <li><?= h ( $error ) ?></li>
          <?php endforeach; ?>
          </div>
      </div><?php 
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

// 開発環境時のみ、引数をvar_dumpで出力します。
function dump( $data ) {
    if ( getenv('ENV_MODE') !== false ) {
        // 本番環境
        // 何も表示しません。
    } else {
        // 開発環境
        // var_dump( $data );
    }
}

function pagination( $datas, $limit = 25 ) {

    // ガード処理
    if ( count( $datas ) == 0 ) {
        return array();
    }

    $request_page = filter_input( INPUT_GET, "page" );

    if ( $request_page ) {
        if ( ! is_numeric( $request_page ) ) {
            // string型
            message_display( 'danger', 'pageパラメータは数値を指定してください' );
            exit();
        } else {
            $page = $request_page;
        }
    } else {
        $page =1;
    }

    $page_count = ceil( count( $datas ) / $limit );

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

    $response =  array();

    // 例： 総件数 84件 datas配列の83件目までループの対象になる
    for ( $i = 0; $i <= $limit && $start +$i <= count( $datas ) -1; $i++ ) {
        $response[] = $datas[$start+$i];
    }
    
    return $response;
}
