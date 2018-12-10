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
?> 

<!-- id (自分のid)と相手ユーザのid(other_id)が指定されている場合  -->
<?php if( $other_id ): ?>
<div class="container">
    <h1><a href="user_show.php?id=<?=h( $other_user['id'] ) ?>">
        @<?=h( $other_user['nickname'] ) ?></a>さんとのチャット画面です
    </h1>

    <form method="post">
        <div class="message-form">
            <div class="form-group">
                <label>Message</label>
                <input type="text" name="content" class="form-control form-control-lg" placeholder="Message @<?= h( $other_user['nickname'] ) ?>">
            </div>
            <button type="submit" class="btn-info btn-lg" name="send_message">メッセージを送る</button>
        </div>
    </form>
    <?php $messages = get_ChatMessages( $other_id ); ?>
    <div class="messages">
    <?php foreach ( $messages as $message ): ?>
    <!-- 自分が相手に送信したメッセージの場合 -->
        <?php if ( is_CurrentUser_id( $message['writer_user_id'] ) ): ?>
        <div class= "my-message message">
            <?php if ( img_exists( session_get( 'image' ) ) ): ?>
            <img src=<?= h( get_image_path( session_get( 'image' ) ) ) ?> class="img-circle user-image-short" alt="...">
            <?php endif; ?> 
            <?=h( $message['content'] ) ?>
        </div>
        <hr>
        <?php else: ?>
        <div class= "other-user-message message">
            <?php if ( img_exists( $other_user_image = get_user_info( $other_id, 'image' ) ) ): ?>
            <img src=<?= h( get_image_path( $other_user_image ) ) ?> class="img-circle user-image-short" alt="...">
            <?php endif; ?> 
            <?=h( $message['content'] ) ?>
        </div>
        <hr>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
</div>
<!-- id (ログインユーザのid)のみ指定されている場合  -->
<?php else: ?>
<div class="container">
    <h1>DMを送信する</h1>
    <form method="post">
        <div class="form-group">
            <label>nickname</label>
            <input type="text" name="nickname" class="form-control form-control-lg">
        </div>
        <button type="submit" class="btn-primary btn-lg" name="action">メッセージ画面に移動する</button>
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
</div>