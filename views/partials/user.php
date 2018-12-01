
<?php var_dump( $user ) ?>
<div class="container">
    <div class="card card--extend">
        <div class="card-body">
            <a href ="user_show.php?id=<?=h ( $user['id'] ); ?>" class= user-link>
            <?php $user_image = '../images/' . $user['image']; ?>
            <?php if ( file_exists( $user_image ) &&  ! is_dir( $user_image ) ): ?>
            <img src=<?=h( $user_image ) ?> class="img-circle user-image" alt="...">
            <?php endif; ?>
            <h1 class="card-title">@<?=h( $user['nickname'] ); ?></h1>
            <p class="card-body">
            follower:<?=h ( get_relationship_count( 'follower' ,$user['id'] ) ); ?><br>
            following:<?=h ( get_relationship_count( 'following' ,$user['id'] ) ); ?><br>
            like:<?=h ( get_like_posts( $user['id'], 'count' ) ); ?>
            </a>
            <?php if( !  is_Current_user( $user['id'] ) ): ?>
            <?php if ( ! is_following( $user['id'] ) ): ?>
            <form method="POST">
            <input type="hidden" name="follow_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-primary btn-lg" name= "follow" >
            <?=h ( $user['user_name'] ) ?>をフォローする<br>
            </form>

            <?php else: ?>
            <form method="POST">
            <input type="hidden" name="unfollow_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-info btn-lg" name= "unfollow" >
            <?=h ( $user['user_name'] ) ?>のフォローを解除する</button>
            </form>
            <?php endif; ?>
                       
            <?php if ( is_Admin() ): ?>
            <form method="POST" action = "" onsubmit="return check();">
            <input type="hidden" name="delete_id" value="<?=h ( $user['id'] ) ?>"/>
            <button type="submit" class="btn btn-danger btn-lg" name= "action" ><?=h( $user['user_name'] ) ?>を削除する</button>
            </form>
            <?php endif; ?>
            <?php endif; ?>
            </p>
        </div>
    </div>
</div>