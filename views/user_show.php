<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/dbconfig.php" );
require ( get_require_dir() . "/common.php" );
require ( get_require_dir() . "/session.php" );
require ( get_require_dir() . "/user.php" );
require ( get_require_dir() . "/following.php" );
require ( get_require_dir() . "/like.php" );
require ( get_require_dir() . "/navbar.php" );

if ( get_Get( 'id' )  && is_numeric( get_Get( 'id' )  ) ) {
    $user = find( 'users' , get_Get( 'id' )  );
} else {
    header( "Location:users.php" );
    exit();
}    

if ( is_Submit() ) {
    user_delete( get_Post( 'user_id' ) );
}

if ( is_Submit( 'follow' ) ) {
    follow( get_Post( 'user_id' ) );
}

if ( is_Submit( 'unfollow' ) ){
    unfollow( get_Post( 'user_id' ) );
}

if ( is_Submit( 'like' )  ) {
    like( get_Post( 'post_id' ) );
}

if ( is_Submit( 'unlike' ) ) {
    unlike( get_Post( 'post_id' ) );
}

require ( get_partials_dir() . "/user.php" );

?>


<div class="col-lg-6">
    <h2 id="nav-tabs">Tabs</h2>
    <div class="bs-component">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="#tab1" class="nav-link" data-toggle="tab">Posts</a>
            </li>
            <li class="nav-item">
                <a href="#tab2" class="nav-link" data-toggle="tab">Following</a>
            </li>
            <li class="nav-item">
                <a href="#tab3" class="nav-link" data-toggle="tab">Follower</a>
            </li>
            <li class="nav-item">
                <a href="#tab4" class="nav-link" data-toggle="tab">Like</a>
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
        $query = "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY updated_at DESC";
        $result = query( $query );
        $posts = pagination( $result['datas'] );
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
        $followings = get_relationships( 'following' , $user_id );
        $followings = pagination( $followings );
        ?>
        <h1>Following:<?php print( count( $followings ) ); ?></h1>
        <?php if ( count( $followings ) > 0 ): ?>
        <?php foreach ( $followings as $user ): ?> 
        <?php require ( get_partials_dir() . "/user.php" ); ?>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>

        <div class="tab-pane" id="tab3">
        <?php
        $followers = get_relationships( 'follower' , $user_id );
        $followers = pagination( $followers );
        ?>
        <h1>Follower:<?php print( count( $followers ) ); ?></h1>
        <?php if ( count( $followers ) > 0 ): ?>
        <?php foreach ( $followers as $user ): ?> 
        <?php require ( get_partials_dir() . "/user.php" ); ?>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>

        <div class="tab-pane" id="tab4">
        <?php
        $likes = get_like_posts( $user_id );
        $likes = pagination( $likes );
        ?>
        <h1>Liked posts:<?php print( count( $likes ) ); ?></h1>
        <?php if ( count( $likes ) > 0 ): ?>
        <?php foreach ( $likes as $post ): ?> 
        <?php require ( get_partials_dir() . "/post.php" ); ?>
        <?php endforeach; ?>
        <?php endif; ?>
        </div>
    </div>
</div>