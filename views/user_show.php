<?php

require (  "../setting_func.php" );
require ( get_require_dir() . "/user.php" );
require ( get_require_dir() . "/relationship.php" );
require ( get_require_dir() . "/like.php" );
require ( get_require_dir() . "/retweet.php" );

$user = find_by( 'users' , get_Get( 'id' )  );
var_dump( $user['id'] );

if ( ! get_Get( 'id' )  || ! is_numeric( get_Get( 'id' )  ) || ! $user ) {
    header( "Location:users.php" );
    exit();
}    

if ( is_Submit() ) {
    user_delete( get_Post( 'user_id' ) );
}

if ( is_Submit( 'follow' ) ) {
    follow( get_Post( 'follow_id' ) );
}

if ( is_Submit( 'unfollow' ) ) {
    unfollow( get_Post( 'unfollow_id' ) );
}

if ( is_Submit( 'like' )  ) {
    like( get_Post( 'post_id' ) );
}

if ( is_Submit( 'unlike' ) ) {
    unlike( get_Post( 'post_id' ) );
}

if ( is_Submit( 'retweet' ) ) {
    retweet( get_Post( 'post_id' ) );
}

if ( is_Submit( 'unretweet' ) ) {
    unRetweet( get_Post( 'post_id' ) );
}

if ( is_Submit( 'block' ) ) {
    block( get_Post( 'blocked_user_id' ) );
}

if ( is_Submit( 'unBlock' ) ) {
    unBlock( get_Post( 'blocked_user_id' ) );
}

if ( is_Submit( 'lock' ) ) {
    lock();
}

if ( is_Submit( 'unLock' ) ) {
    unLock();
}

if ( is_Submit( 'followRequest' ) ) {
    followRequest( get_Post( 'follow_request_id' ) );
}



require ( get_partials_dir() . "/user.php" );

?>


<h1>User Info</h1>

<!--タブ-->
<ul class="nav nav-tabs">
    <li class="active">
        <a href="#tab1" class="nav-link" data-toggle="tab">Posts</a>
    </li>
    <li>
        <a href="#tab2" class="nav-link" data-toggle="tab">Following</a>
    </li>
    <li class="nav-item">
        <a href="#tab3" class="nav-link" data-toggle="tab">Follower</a>
    </li>
    <li class="nav-item">
        <a href="#tab4" class="nav-link" data-toggle="tab">Like</a>
    </li>
</ul>


<!-- / タブ-->
<div id="myTabContent" class="tab-content">
    <?php $user_id = $user['id'] ?>

    <div class="tab-pane active" id="tab1">
        <?php
        $posts = get_user_post( $user_id );
        $posts = pagination( $posts );
        ?>
        <h1>Post:<?php print( count( $posts ) ); ?></h1>
        <?php require_foreach( $posts, 'post', get_partials_dir() . "/post.php" ) ?>
    </div>

    <div class="tab-pane" id="tab2">
        <?php
        $followings = get_relationships_user( 'following' , $user_id );
        $followings = pagination( $followings );
        ?>
        <h1>Following:<?php print( count( $followings ) ); ?></h1>
        <?php require_foreach( $followings, 'user' , get_partials_dir() . "/user.php" ) ?>
    </div>

    <div class="tab-pane" id="tab3">
        <?php
        $followers = get_relationships_user( 'follower' , $user_id );
        $followers = pagination( $followers );
        ?>
        <h1>Follower:<?php print( count( $followers ) ); ?></h1>
        <?php require_foreach( $followers, 'user' , get_partials_dir() . "/user.php" ) ?>
    </div>

    <div class="tab-pane" id="tab4">
    <?php
        $likes = get_like_posts( $user_id );
        // $likes = pagination( $likes );
        // var_dump( $likes );
        ?>
        <h1>Liked posts:<?php print( count( $likes ) ); ?></h1>
        <?php require_foreach( $likes, 'post' , get_partials_dir() . "/post.php" ) ?>
    </div>
</div>

<?php /*
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
    <?php $user_id = $user['id']; 
            $likes = get_like_posts( $user_id );
            $likes = pagination( $likes );
            var_dump( $likes );?>

    <!-- タブのコンテンツ部分 -->
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
        <?php
        $posts = get_user_post( $user_id );
        $posts = pagination( $posts );
        ?>
        <h1>Post:<?php print( count( $posts ) ); ?></h1>
        <?php require_foreach( $posts, 'post', get_partials_dir() . "/post.php" ) ?>
        </div>

        <div class="tab-pane" id="tab2">
        <?php
        $followings = get_relationships_user( 'following' , $user_id );
        $followings = pagination( $followings );
        ?>
        <h1>Following:<?php print( count( $followings ) ); ?></h1>
        <?php require_foreach( $followings, 'user' , get_partials_dir() . "/user.php" ) ?>
        </div>

        <div class="tab-pane" id="tab3">
        <?php
        $followers = get_relationships_user( 'follower' , $user_id );
        $followers = pagination( $followers );
        ?>
        <h1>Follower:<?php print( count( $followers ) ); ?></h1>
        <?php require_foreach( $followers, 'user' , get_partials_dir() . "/user.php" ) ?>
        </div>

        <div class="tab-pane" id="tab4">
        <?php
        $likes = get_like_posts( $user_id );
        // $likes = pagination( $likes );
        // var_dump( $likes );
        ?>
        <h1>Liked posts:<?php print( count( $likes ) ); ?></h1>
        <?php require_foreach( $likes, 'post' , get_partials_dir() . "/post.php" ) ?>
        </div>
    </div>
</div>

*/ ?>