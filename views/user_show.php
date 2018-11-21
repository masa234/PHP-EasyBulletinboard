<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/user.php" );
require ( get_require_dir() . "/following.php" );
require ( get_require_dir() . "/navbar.php" );

if ( isset( $_POST['action'] ) ) {
    user_delete( $_POST['user_id'] );
}

if ( isset( $_POST['follow'] ) ) {
    follow( $_POST['user_id'] );
}

if ( isset( $_POST['unfollow'] ) ) {
    unfollow( $_POST['user_id'] );
}

if ( isset( $_REQUEST['id'] ) && is_numeric( $_REQUEST['id'] ) ) {
    $user = get_user( $_REQUEST['id'] );
} else {
    header( "Location:users.php" );
    exit();
}    

require ( get_partials_dir() . "/user.php" );

?>


<div class="col-lg-6">
    <h2 id="nav-tabs">Tabs</h2>
    <div class="bs-component">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="#tab1" class="nav-link" data-toggle="tab" >Posts</a>
            </li>
            <li class="nav-item">
                <a href="#tab2" class="nav-link" data-toggle="tab" href="#profile">Following</a>
            </li>
            <li class="nav-item">
                <a href="#tab3" class="nav-link" data-toggle="tab" href="#profile">Follower</a>
            </li>
            <li class="nav-item dropdown">
                <a href="#tab4" class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Like</a>
            </li>
        </ul>
    </div>
</div>

<div id="tab">    
    <?php $user_id = escape( $user['id'] ); ?>

    <!-- タブのコンテンツ部分 -->
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
        <?php
        $posts = pagination( 'posts', 'updated_at', 'DESC', 10, 'WHERE user_id = ' .$user_id );
        ?>
        <h1>Post:<?php print( count( $posts ) ); ?></h1>
        <?php if ( count( $posts ) > 0 ): ?>
        <?php foreach ( $posts as $post ): ?> 
        <?php require ( get_partials_dir() . "/post.php" ); ?>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>

        <div class="tab-pane" id="tab2">
        <?php
        $users = get_relationships( 'following' , $user_id );
        // $users = pagination( 'followings', 'followed_id', 'DESC', 10, 'WHERE followed_id = ' .$user_id );
        ?>
        <h1>Follower:<?php print( count( $users ) ); ?></h1>
        <?php if ( count( $users ) > 0 ): ?>
        <?php foreach ( $users as $user ): ?> 
        <?php require ( get_partials_dir() . "/user.php" ); ?>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>

        <div class="tab-pane" id="tab3">
        <?php
        $users = get_relationships( 'follower' , $user_id );
        // $users = pagination( 'followings', 'followed_id', 'DESC', 10, 'WHERE followed_id = ' .$user_id );
        ?>
        <h1>Follower:<?php print( count( $users ) ); ?></h1>
        <?php if ( count( $users ) > 0 ): ?>
        <?php foreach ( $users as $user ): ?> 
        <?php require ( get_partials_dir() . "/user.php" ); ?>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
        <div class="tab-pane" id="tab4">DDDD</div>
    </div>
</div>