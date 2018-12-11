<?php 

require (  "../setting_func.php" );
require (  get_require_dir() . "/user.php" );
require (  get_require_dir() . "/chat.php" );

$current_id = get_Get( 'id' );
if ( ! $current_id || $current_id !=  session_get( 'id' ) ) {
    // id: id (自分のid)が指定されていない場合、もしくは自分以外のユーザのidを指定している
    flash( '他のユーザのメッセージ送信画面です', 'danger' );
    redirect_back();
}

$other_id = get_Get( 'other_id' );
if ( $other_id ) {
    if ( $other_id == $current_id || ! $other_user = find_by( 'users', $other_id ) ) {
        // other_id: 存在しないユーザのidまたは、ログインユーザのidを指定している
        flash( '指定されたidを持つユーザは存在しません', 'danger' );
        redirect_back();
    }
}

if ( is_Submit() ) {
    startChat( get_Post( 'nickname' ) );
}

if ( is_Submit( 'send_message' ) ) {
    speak( get_Post( 'content') , $other_user['id'] );
}

if ( is_Submit( 'del_message' ) ) {
    del_message( get_Post( 'del_message_id' ) );
}
?> 

<div class="container">
<?php if ( get_unread_message( 'count' ) > 0 ): ?>
<?php alert( 'danger', '未読messageが' . get_unread_message( 'count' )  . '件あります' ) ?>
<?php chat( $unreads = get_unread_message() ) ?>
<?php endif; ?>

<!-- id (自分のid)と相手ユーザのid(other_id)が指定されている場合  -->
<?php if( $other_id ): ?>
<h1><a href="user_show.php?id=<?=h( $other_user['id'] ) ?>">
    @<?=h( $other_user['nickname'] ) ?></a>さんとのチャット画面です
</h1>

<form method="post">
    <div class="message-form">
        <div class="form-group">
            <label>Message</label>
            <input type="text" name="content" class="form-control form-control-lg" id ="message_content" placeholder="Message @<?= h( $other_user['nickname'] ) ?>">
        </div>
        <button type="submit" class="btn-info btn-lg" id="message_send" name="send_message">メッセージを送る</button>
    </div>
</form>
<?php $messages = get_ChatMessages( $other_id ); ?>
<?php chat( $messages, $other_id ) ?>
<!-- id (ログインユーザのid)のみ指定されている場合  -->
<?php else: ?>
<h1>DMを送信する</h1>
<form method="post">
    <div class="form-group">
        <label>nickname</label>
        <input type="text" name="nickname" class="form-control form-control-lg">
    </div>
    <button type="submit" class="btn-primary btn-lg" name="action">チャット画面に移動する</button>
</form>
<div class="message-users">
<?php $users = all( 'users' ) ?>
<?php foreach( $users as $user ): ?>
<?php if ( $user['id'] != get_current_user_id() ): ?>
<a href="room.php?id=<?= session_get( 'id' ) ?>&other_id=<?=h( $user['id'] )?>"  class="message_user">@<?=h( $user['nickname'] ) ?></a>
<?php endif ?>
<?php endforeach; ?>
<?php endif; ?>
</div>
