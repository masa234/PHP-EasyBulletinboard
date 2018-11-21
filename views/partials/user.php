<div class="container">
    <div class="card card--extend">
        <div class="card-body">
            <a href ="user_show.php?id=<?php print h ( $user['id'] ); ?>" class= user-link>
            <?php $user_image = '../images/' . $user['image']; ?>
            <?php if ( file_exists( $user_image ) &&  ! is_dir( $user_image ) ): ?>
            <img src=<?php print h( $user_image ) ?> class="img-circle user-image" alt="...">
            <?php endif; ?>
            <h1 class="card-title">@<?php print h( $user['nickname'] ); ?></h1>
            <p class="card-body">
            follower:<?php print h ( get_relationship_count( 'follower' ,$user['id'] ) ); ?><br>
            following:<?php print h ( get_relationship_count( 'following' ,$user['id'] ) ); ?>
            </a>
            <?php if( !  is_Current_user( $user['id'] ) ): ?>
            <?php if ( ! is_following( $user['id'] ) ): ?>
            <form method="POST">
            <input type="hidden" name="user_id" value="<?php print h( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-primary btn-lg" name= "follow" >
            <?php print h( $user['user_name'] ) ?>をフォローする<br>
            <?php else: ?>
            <form method="POST">
            <input type="hidden" name="user_id" value="<?php print h( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-info btn-lg" name= "unfollow" >
            <?php print h( $user['user_name'] ) ?>のフォローを解除する</button>
            <?php endif; ?>           
            <?php if ( is_Admin() ): ?>
            <form method="POST" action = "" onsubmit="return check();">
            <input type="hidden" name="user_id" value="<?php print h( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-danger btn-lg" name= "action" >削除する</button>
            <?php endif; ?>
            <?php endif; ?>
            </p>
        </div>
    </div>
</div>