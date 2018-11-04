

<div class="jumbotron"> 
    <p class="lead">
    <?php $gravator_url = getGravatarUrl( $user['email'] ); ?>
    <img src="<?php print h( $gravator_url ); ?>" class="img-circle" alt="...">
    <?php print h( $user['username'] ); ?>
    </p>
    <?php if ( ! isCurrent_user( $user['id'] ) ): ?>
    <form action="user_delete.php" method="POST" onsubmit="return check();">
    <input type="hidden" name="user_id" value="<?php print h( $user['id'] ) ?>"/>
    <button type ="submit" class="btn btn-danger btn-lg" href="user_delete.php">削除する</a>
    </form>
    <?php endif; ?> 
</div>